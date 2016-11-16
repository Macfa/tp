<?php
class planCalculator {
	
	private $dvId;
	private $dvKey;
	private $dvCate;
	private $carrier;
	private $applyType;
	private $discountType;
	private $deviceType;
	private $plan;

	private $selectedCarrier = '';
	private $selectedDeviceType = '';
	private $selectedApplyType = '';
	private $selectedDiscountType = '';
	private $selectedCapacity = '';
	private $selectedPlan = '';

	private $defaultInfo = NULL;
	private $deviceInfo = NULL;

	private $arrResultRow = array();

	private $arrVatContain = array(1=>'포함(실청구액)', 0=>'포함안된 요금');
	private $arrDeviceType = array();
	private $arrDiscountType = array();
	private $arrApplyType = array();
	private $arrCarrierType = array();
	private $arrPlan = array();

	private $carrierTypeCount = 0;
	private $deviceTypeCount = 0;
	private $applyTypeCount = 0;
	private $discountTypeCount = 2;
	private $capacityCount = 0;

	private $isExistChild = false;
	private $calcRowAffix = '';

	private $calculatorPad = '';
	private $calculatorResult = '';
	private $calculator = '';

	private $lockedPropertyCount = 0;
	private $lockIcon = '<i class="ico-lock"></i>';
	private $capacityLockIcon = '';
	private $applyTypeLockIcon = '';
	private $discountTypeLockIcon = '';
	private $deviceTypeLockIcon = '';
	private $carrierTypeLockIcon = '';

	private $htmlPadTemplate = '<div class="calc-pad-wrap js-calcPad">{content}</div>';

	private $htmlPadWrapTemplate = '<fieldset class="calc-row-{calcRowAffix}">
																<div class="calc-row-label">{tit}</div>
																{content}
															</fieldset>';

	private $htmlPadButtonTemplate = '<label class="calc-btn">
																<input type="radio" value="{value}" name="{name}" {isChecked}/>
																<div class="calc-label">{lockIcon} {label}</div>
															</label>';

	private $htmlPlanSelectWrapTemplate = '<div class="calc-row">
																		<div class="calc-row-label">{tit}</div>
																		<select class="inp-select js-planCalcArg" name="plan">{content}</select>
																	</div>';

	private $htmlPlanSelectOptionTemplate = '<option value="{value}" {isSelected}>{name} : {info}</option>';

	private $htmlResultRowTemplate = '<tr class="calc-value-row {class} {isActiveClass}">
																<td class="calc-value-label">{label}</td>
																<td>{totalSign}</td>
																<td class="{totalColumnClass}">{totalValue}</td>
																<td>{perMonthSign}</td>
																<td class="{perMonthColumnClass}">{perMonthValue}</td>
															</tr>';

	private $htmlResultTotalTemplate = '<tr class="calc-result-row">
																<td class="calc-result-label">월 청구액</td>
																<td>{sign}</td>
																<td class="calc-result-price js-result" colspan="3"><div style="overflow:hidden;height:100%;">{result}</div></td>
															</tr>';

	private $htmlResultWrapTemplate = '<div class="calc-result-wrap">
																	<table class="calc-result-table">
																		<colgroup>
																			<col style="width:47%" />
																			<col style="width:10px" />
																			<col style="width:auto" />
																			<col style="width:10px" />
																			<col style="width:auto" />
																		</colgroup>
																		<thead>
																			<tr>
																				<th></th>				
																				<th colspan="2">총 액</th>
																				<th colspan="2">매월(24)</th>
																			</tr>
																		</thead>
																		<tbody>{content}</tbody>
																	</table>
																</div>';

	private $htmlCalculatorTemplate = '<section class="calc-wrap js-hideContactBtn">
																<input type="hidden" class="js-id" name="dvId" value="{dvKey}"/>
																<input type="hidden" class="js-token" value="{token}"/>
																{content}
																<div class="spacer" style="clear: both;"></div>
															</section>';

	public function setDevice($dvId) {
		$this->dvId = $dvId;
		return $this;
	}

	public function setCarrier($carrier = null) {
		$this->selectedCarrier = $this->carrier = $carrier;
		$this->carrier = strtolower($this->carrier);
		return $this;
	}

	public function setCapacity($capacity = null) {
		$this->capacity = $capacity;
		$this->capacity = strtoupper($this->capacity);
		return $this;
	}

	//LTE형 3G형 같은 용량외 세부 기기 종류 
	public function setDeviceType($deviceType = null) {
		$this->deviceType = $deviceType;
		return $this;
	}

	public function setApplyType($applyType = null) {
		$this->applyType = $applyType;
		return $this;
	}

	public function setDiscountType($discountType = null) {
		$this->discountType = $discountType;
		return $this;
	}

	public function setPlan($plan = null) {
		$this->plan = $plan;
		return $this;
	}

	public function create() {
		$this->init()->setCarrierSelect()->setDeviceTypeSelect()->setCapacitySelect()->setApplyTypeSelect()->setDiscountTypeSelect()->setVatContainSelect()->setPlanSelect();
		return $this->getCalculator();
	}

	private function init() {
		$this->dvKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvId = %s", $this->dvId);

		$this->capacityCount = DB::queryFirstField("SELECT COUNT(dvKey) as cnt FROM tmDevice WHERE dvDisplay = 1 and dvParent = %i", $this->dvKey);
		if ((int)$this->capacityCount === 0) {
			$this->lockedPropertyCount += 1;
			$this->isExistChild = true;
			$this->capacityLockIcon = $this->lockIcon;
		}

		//--------------------------------------------

		$this->dvCate = DB::queryFirstField("SELECT dvCate FROM tmDevice WHERE dvKey = %i", $this->dvKey);
		$deviceInfo = new deviceInfo();
		$deviceInfo->setCarrier($this->carrier)->setMode($this->dvCate);

		//-------------------------------------------

		$this->arrApplyType = $deviceInfo->getArrApplyType();
		$this->applyTypeCount = count($this->arrApplyType);

		if($this->applyTypeCount == 1) {
			$this->lockedPropertyCount += 1;
			$this->applyTypeLockIcon = $this->lockIcon;
		}

		//--------------------------------------------

		$this->arrDiscountType = $deviceInfo->getArrDiscountType();
		$this->discountTypeCount = count($this->arrDiscountType);

		if ($this->discountTypeCount == 1) {
			$this->lockedPropertyCount += 1;
			$this->discountTypeLockIcon = $this->lockIcon;
		}

		//-----------------------------------------

		$this->arrDeviceType = $deviceInfo->getArrDeviceType();
		$this->deviceTypeCount = count($this->arrDeviceType);

		if ($this->deviceTypeCount == 1) {
			$this->lockedPropertyCount += 1;
			$this->deviceTypeLockIcon = $this->lockIcon;
		}

		//------------------------------------------

		$this->arrCarrierType = $deviceInfo->getArrCarrierType($this->dvKey);
		$this->carrierTypeCount = count($this->arrCarrierType);

		if ($this->carrierTypeCount == 1) {
			$this->lockedPropertyCount += 1;
			$this->carrierTypeLockIcon = $this->lockIcon;
		}

		//--------------------------------------------------------

		$this->arrPlan = $deviceInfo->getArrPlan();

		//---------------------------------------------------
		return $this;
	}

	public function setCarrierSelect(){

		if (isExist($this->carrier)) {
			foreach ($this->arrCarrierType as $key => $val) {
				if ($key == $this->carrier) {
					$carrierTypeChecked[$key]['isChecked'] = 'checked';
				}
			}
		}else{
			$carrierTypeChecked[getFirstArrKey($this->arrCarrierType)]['isChecked'] = 'checked';
		}

		foreach ($this->arrCarrierType as $key => $val) {
			$data['value'] = $key;
			$data['label'] = $val;
			$data['name'] = 'carrier';
			$data['isChecked'] = $carrierTypeChecked[$key]['isChecked'];
			$data['lockIcon'] = $this->carrierTypeLockIcon;
			$content .= getResultTemplate($data, $this->htmlPadButtonTemplate);
		}

		$data = array();
		$data['tit'] = '통신사선택';
		$data['content'] = $content;
		$data['calcRowAffix'] = ($this->carrierTypeCount==1)?'lock-'.$this->lockedPropertyCount:$this->carrierTypeCount;
		$this->calculatorPad .= getResultTemplate($data, $this->htmlPadWrapTemplate);
		return $this;
	}

	public function setDeviceTypeSelect(){
		if ($this->deviceTypeCount == 0) return $this;

		if (isExist($this->deviceType)) {
			foreach ($this->arrDeviceType as $val) {
				if ($val == $this->deviceType) {
					$deviceTypeChecked[$val]['isChecked'] = 'checked';
				}
			}
		}else{
			
			$deviceTypeChecked[$this->arrDeviceType[getFirstArrKey($this->arrDeviceType)]]['isChecked'] = 'checked';
		}

		if($this->deviceTypeCount === 1) {
			
			$this->selectedDeviceType = $this->arrDeviceType[getFirstArrKey($this->arrDeviceType)];
		} else if(isExist($this->deviceType)){
			$this->selectedDeviceType = $this->deviceType;
		}

		foreach ($this->arrDeviceType as $val) {
			$data['label'] = $data['value'] = $val;
			$data['name'] = 'deviceType';
			$data['isChecked'] = $this->arrDeviceType[$val]['isChecked'];
			$data['lockIcon'] = $this->deviceTypeLockIcon;
			$content .= getResultTemplate($data, $this->htmlPadButtonTemplate);
		}

		$data = array();
		$data['tit'] = '기기종류';
		$data['content'] = $content;
		$data['calcRowAffix'] = ($this->deviceTypeCount===1)?'lock-'.$this->lockedPropertyCount:$this->deviceTypeCount;
		$this->calculatorPad .= getResultTemplate($data, $this->htmlPadWrapTemplate);
		return $this;
	}

	public function setCapacitySelect(){
		if($this->capacityCount == 0) return $this;

		$child = DB::query("SELECT * FROM tmDevice WHERE dvDisplay = 1 and dvParent = %i", $this->dvKey);
		if (isExist($this->capacity)) {
			foreach ($child as $key => $val) {
				if ($val['dvTit'] == $this->capacity) {
					$child[$key]['isChecked'] = 'checked';
				}
			}
		}/*else{
			$child[0]['isChecked'] = 'checked';
		}*/

		if(isExist($this->capacity)){
			$this->selectedCapacity = $this->capacity;
		}else if($this->capacityCount == 1) {
			$this->selectedCapacity = $child[0]['dvTit'];
		}

		foreach ($child as $key => $val) {
			$data['label'] = $data['value'] = $val['dvTit'];
			$data['name'] = 'capacity';
			$data['isChecked'] = $child[$key]['isChecked'];
			$data['lockIcon'] = $this->capacityLockIcon;
			$content .= getResultTemplate($data, $this->htmlPadButtonTemplate);
		}
		$data = array();
		$data['tit'] = '기기용량';
		$data['content'] = $content;
		$data['calcRowAffix'] = ($this->capacityCount===1)?'lock-'.$this->lockedPropertyCount:$this->capacityCount;
		$this->calculatorPad .= getResultTemplate($data, $this->htmlPadWrapTemplate);
		return $this;
	}

	public function setApplyTypeSelect(){
		if (isExist($this->applyType)) {
			foreach ($this->arrApplyType as $key => $val) {
				if ($key == $this->applyType) {
					$applyTypeChecked[$key]['isChecked'] = 'checked';
				}
			}
		} else {
			
			$applyTypeChecked[getFirstArrKey($this->arrApplyType)]['isChecked'] = 'checked';
		}

		if($this->applyTypeCount == 1) {
			$this->selectedApplyType = getFirstArrKey($this->arrApplyType);
		} else if(isExist($this->applyType)){
			$this->selectedApplyType = $this->applyType;
		}

		foreach ($this->arrApplyType as $key => $val) {
			$data['value'] = $key;
			$data['label'] = $val;
			$data['name'] = 'applyType';
			$data['isChecked'] = $applyTypeChecked[$key]['isChecked'];
			$data['lockIcon'] = $this->applyTypeLockIcon;
			$content .= getResultTemplate($data, $this->htmlPadButtonTemplate);
		}
		$data = array();
		$data['tit'] = '가입유형';
		$data['content'] = $content;
		$data['calcRowAffix'] = ($this->applyTypeCount===1)?'lock-'.$this->lockedPropertyCount:$this->applyTypeCount;
		$this->calculatorPad .= getResultTemplate($data, $this->htmlPadWrapTemplate);
		return $this;
	}

	public function setDiscountTypeSelect(){

		if (isExist($this->discountType)) {
			foreach ($this->arrDiscountType as $key => $val) {
				if ($key == $this->discountType) {
					$discountTypeChecked[$key]['isChecked'] = 'checked';
				}
			}
		} else if($this->discountTypeCount == 1){
			
			$discountTypeChecked[getFirstArrKey($this->arrDiscountType)]['isChecked'] = 'checked';
		}

		if($this->discountTypeCount == 1) {
			$this->selectedDiscountType = getFirstArrKey($this->arrDiscountType);
		} else if(isExist($this->discountType)){
			$this->selectedDiscountType = $this->discountType;
		}

		foreach ($this->arrDiscountType as $key => $val) {
			$data['value'] = $key;
			$data['label'] = $val;
			$data['name'] = 'discountType';
			$data['isChecked'] = $discountTypeChecked[$key]['isChecked'];
			$data['lockIcon'] = $this->discountTypeLockIcon;
			$content .= getResultTemplate($data, $this->htmlPadButtonTemplate);
		}
		$data = array();
		$data['tit'] = '할인방식';
		$data['content'] = $content;
		$data['calcRowAffix'] = ($this->discountTypeCount===1)?'lock-'.$this->lockedPropertyCount:$this->discountTypeCount;
		$this->calculatorPad .= getResultTemplate($data, $this->htmlPadWrapTemplate);
		return $this;
	}

	public function setVatContainSelect(){
		foreach ($this->arrVatContain as $key => $val) {
			$data['value'] = $key;
			$data['label'] = $val;
			$data['name'] = 'containVat';
			$content .= getResultTemplate($data, $this->htmlPadButtonTemplate, true);
		}
		$data = array();
		$data['tit'] = '부가세 & 할부이자';
		$data['content'] = $content;
		$data['calcRowAffix'] = 2;
		$this->calculatorPad .= getResultTemplate($data, $this->htmlPadWrapTemplate);
		return $this;
	}

	public function setPlanSelect(){
		$tmpDeviceInfo = new deviceInfo();
		$tmpDeviceInfo->setCarrier($this->carrier)->setMode($this->dvCate);
		$this->selectedPlan = (isExist($this->plan))?$this->plan:getFirstArrKey($this->arrPlan);
		////var_dump($this->arrPlan);
		//var_dump($this->selectedPlan);
		$planSelected[$this->selectedPlan] = 'selected';

		foreach ($this->arrPlan as $val) {
			$data['value'] = $val;
			$data['name'] = $tmpDeviceInfo->getPlanName($val);
			$data['info'] = $tmpDeviceInfo->getPlanInfo($val);
			$data['isSelected'] = $planSelected[$val];
			$content .= getResultTemplate($data, $this->htmlPlanSelectOptionTemplate);
		}

		$data = array();
		$data['tit'] = '요금제';
		$data['content'] = $content;
		$this->calculatorPad .= getResultTemplate($data, $this->htmlPlanSelectWrapTemplate);
		return $this;
	}

	private function getDefaultInfo(){
		$data['carrier'] = $this->selectedCarrier;
		$data['capacity'] = $this->selectedCapacity;
		$data['discountType'] = $this->selectedDiscountType;
		$data['applyType'] = $this->selectedApplyType;
		$data['plan'] = $this->selectedPlan;
		$data['id'] = $this->dvId;
		//var_dump($data);
		$this->defaultInfo = getPlanInfo($data);
		//var_dump($this->defaultInfo);
		return $this;
	}

	private function setArrResultRow(){
		$this->arrResultRow = array(
												array(
													'template' => $this->htmlResultRowTemplate,
													'label' => '출고가',
													'totalColumnClass' => 'js-retailPrice',
													'perMonthColumnClass' => 'js-retailPricePerMonth',
													'class' => '',
													'isActiveClass' => '',
													'totalValue' => number_format($this->defaultInfo['dvRetailPrice']),
													'perMonthValue' => number_format(round($this->defaultInfo['dvRetailPrice']/24))
												),
												array(
													'template' => $this->htmlResultRowTemplate,
													'label' => '공시지원금',
													'totalColumnClass' => 'js-support',
													'perMonthColumnClass' => 'js-supportPerMonth',
													'totalSign' => '-',
													'perMonthSign' => '-',
													'class' => 'calc-support-discount',
													'isActiveClass' => ($this->selectedDiscountType == 'support')?'active':'',
													'totalValue' => number_format($this->defaultInfo['spSupport']),
													'perMonthValue' => number_format(round($this->defaultInfo['spSupport']/24))
												),
												array(
													'template' => $this->htmlResultRowTemplate,
													'label' => '티플지원금',
													'totalColumnClass' => 'js-addSupport',
													'perMonthColumnClass' => 'js-addSupportPerMonth',
													'totalSign' => '-',
													'perMonthSign' => '-',
													'class' => 'calc-support-discount',
													'isActiveClass' => ($this->selectedDiscountType == 'support')?'active':'',
													'totalValue' => number_format($this->defaultInfo['spAddSupport']),
													'perMonthValue' => number_format(round($this->defaultInfo['spAddSupport']/24))
												),
												array(
													'template' => $this->htmlResultRowTemplate,
													'label' => '할부이자',
													'totalSign' => '+',
													'perMonthSign' => '+',
													'totalColumnClass' => 'js-interest',
													'perMonthColumnClass' => 'js-interestPerMonth',
													'class' => 'calc-vat'
												),
												array(
													'template' => $this->htmlResultRowTemplate,
													'label' => '단말기할부',
													'totalColumnClass' => 'js-resultDevicePrice',
													'perMonthColumnClass' => 'js-resultDevicePricePerMonth',
													'totalSign' => '=',
													'perMonthSign' => '=',
													'class' => 'calc-result-device-price',
													'totalValue' => number_format($this->defaultInfo['resultDevicePrice']),
													'perMonthValue' => number_format(round($this->defaultInfo['resultDevicePrice']/24))
												),
												array(
													'template' => $this->htmlResultRowTemplate,
													'label' => '요금제기본료',
													'perMonthSign' => '+',
													'perMonthColumnClass' => 'js-planFeePerMonth',
													'perMonthValue' => number_format($this->defaultInfo['planFee'])
												),
												array(
													'template' => $this->htmlResultRowTemplate,
													'label' => '부가세',
													'perMonthSign' => '+',
													'perMonthColumnClass' => 'js-VAT',
													'class' => 'calc-vat'
												),
												array(
													'template' => $this->htmlResultRowTemplate,
													'label' => '선택약정할인',
													'totalColumnClass' => 'js-selectPlanDiscount',
													'perMonthColumnClass' => 'js-selectPlanDiscountPerMonth',
													'class' => 'calc-select-plan',
													'totalSign' => '-',
													'perMonthSign' => '-',
													'isActiveClass' => ($this->selectedDiscountType == 'selectPlan')?'active':'',
													'totalValue' => number_format($this->defaultInfo['selectPlanDiscount']),
													'perMonthValue' => number_format(round($this->defaultInfo['selectPlanDiscount']/24))
												),
												array(
													'template' => $this->htmlResultTotalTemplate,
													'label' => '월 청구액',
													'sign' => '=',
													'result' => number_format(round(($this->defaultInfo['dvRetailPrice'] - $this->defaultInfo['spSupport'] - $this->defaultInfo['spAddSupport'])/24) + $this->defaultInfo['planFee'])
												)
											);
		return $this;
	}

	private function setResultSection() {
		foreach ($this->arrResultRow as $val){
			$this->calculatorResult .= getResultTemplate($val, $val['template'], true);
		}
		return $this;
	}

	private function getCalculator() {
		$this->getDefaultInfo()->setArrResultRow()->setResultSection();

		$data['content'] = $this->calculatorResult;
		$this->calculatorResult = getResultTemplate($data, $this->htmlResultWrapTemplate);

		$data['content'] = $this->calculatorPad;
		$this->calculatorPad = getResultTemplate($data, $this->htmlPadTemplate);

		$template = getTemplateTag();

		$data['content'] = $this->htmlPlanSelectOptionTemplate;
		$data['class'] = 'js-planSelectOptionTemplate';
		$planOptionTemplate = getResultTemplate($data, $template);

		$data['content'] = $this->htmlPadButtonTemplate;
		$data['class'] = 'js-padButtonTemplate';
		$padButtonTemplate = getResultTemplate($data, $template);

		$data['content'] = $this->htmlPadWrapTemplate;
		$data['class'] = 'js-padButtonTemplate';
		$padWrapTemplate = getResultTemplate($data, $template);

		$data = array();
		$data['content'] = $this->calculatorResult.$this->calculatorPad;
		$data['dvKey'] = $this->dvId;
		$data['token'] = createToken();
		$calculator = getResultTemplate($data, $this->htmlCalculatorTemplate);

		return $calculator.$padWrapTemplate.$padButtonTemplate.$planOptionTemplate;
	}
}
?>