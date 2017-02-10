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
	private $dvParentKey = '';

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
	private $arrCarrier = array();
	private $arrPlan = array();

	private $carrierCount = 0;
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
	private $carrierLockIcon = '';

	private $htmlPadTemplate = '<div class="calc-pad-wrap js-calcPad">{content}</div>';

	private $htmlPadWrapTemplate = 
		'<fieldset class="calc-row-{calcRowAffix}">
			<div class="calc-row-label">
				<i class="ico-{ico}-small"></i>
				{tit}
			</div>
			{content}
		</fieldset>';

	private $htmlPadButtonTemplate = 
		'<label class="calc-btn">
			<input type="radio" value="{value}" name="{name}" {isChecked}/>
			<div class="calc-label">{lockIcon} {label}</div>
		</label>';

	private $htmlPlanSelectWrapTemplate = 
		'<div class="calc-row">
			<div class="calc-row-label">
				<i class="ico-{ico}-small"></i>
				{tit}
			</div>
			<select class="inp-select js-planCalcArg" name="plan">{content}</select>
		</div>';

	private $htmlPlanSelectOptionTemplate = '<option value="{value}" {isSelected}>{name} : {info}</option>';

	private $htmlResultWrapTemplate =
	'<div class="calc-result-wrap">
		<div class="calc-result-inner js-calculatorResult">
			<div style="height:5px;"></div>
			<div class="calc-device-section">
				<div class="calc-section-inner">
					<div class="calc-value-row">
						<div class="calc-value-label">출고가</div>
						<div class="calc-value-price"><span class="js-retailPrice price">{dvRetailPrice}</span></div>
					</div>
					<div class="calc-value-row calc-result-row-support js-supportWrap {isSupportRowActive}">
						<div class="calc-value-label">공시지원금</div>
						<div class="calc-value-price"><i class="ico-calculate-minus-positive"></i> <span class="js-support price">{spSupport}</span></div>
					</div>
					<div class="calc-value-row calc-result-row-support js-supportWrap {isSupportRowActive}">
						<div class="calc-value-label">티플지원금</div>
						<div class="calc-value-price"><i class="ico-calculate-minus-positive"></i> <span class="js-addSupport price">{spAddSupport}</span></div>
					</div>
					<div class="calc-value-row calc-result-row-interest js-interestWrap {isInterestRowActive}">
						<div class="calc-value-label">할부이자율(<span class="js-repaymentType">{repaymentType}</span>)</div>
						<div class="calc-value-price"><i class="ico-calculate-plus"></i> <span class="js-interestRate price">5.8</span>%</div>
					</div>
					<div class="calc-section-result">
						<div class="calc-section-result-label">기기할부금</div>
						<div class="calc-section-result-price">월 <span class="js-resultDevicePricePerMonth price">{resultDevicePricePerMonth}</span></div>
					</div>
				</div>
			</div>
			<div class="calc-plan-section">
				<div class="calc-section-inner">
					<div class="calc-value-row">
						<div class="calc-value-label">요금제기본료</div>
						<div class="calc-value-price"><span class="js-planFee price">{planFee}</span></div>
					</div>
					<div class="calc-value-row calc-result-row-selectplan js-selectplanWrap {isSelectPlanDiscountRowActive}">
						<div class="calc-value-label">선택약정할인</div>
						<div class="calc-value-price"><i class="ico-calculate-minus-positive"></i> <span class="js-selectplan price">{selectPlanDiscount}</span></div>
					</div>
					<div class="calc-value-row calc-result-row-interest js-VATWrap {isVATRowActive}">
						<div class="calc-value-label">부가세</div>
						<div class="calc-value-price"><i class="ico-calculate-plus"></i> <span class="js-VAT price">{vat}</span></div>
					</div>
					<div class="calc-section-result">
						<div class="calc-section-result-label">통신요금</div>
						<div class="calc-section-result-price">월 <span class="js-planFeeResult price">{planFeeResult}</span></div>
					</div>
				</div>
			</div>
			<div class="calc-total-wrap">
				<div class="calc-total-inner">
					<div class="calc-point">★포인트 <span class="js-point">{point}</span><span class="js-egg11gEvent txt-highlight" style="display:none">(추가지급이벤트)</span></div>
					<span class="calc-total-label">월</span>
					<span class="calc-total-price js-result">{totalCost}</span>
				</div>
			</div>
			<button class="calc-detail-btn js-calculatorDetailToggle" formnovalidate type="button">
				<i class="ico-more-small"></i>
			</button>
			<div class="calc-support-guide">
				전국 대리점 모두 동일합니다.
			</div>
		</div>
	</div>';

	private $htmlCalculatorTemplate = 
		'<section class="calc-wrap js-hideContactBtn">
			<input type="hidden" class="js-id" name="dvId" value="{dvId}"/>
			<input type="hidden" class="js-key" name="dvKey" value="{dvKey}"/>
			<input type="hidden" class="js-token" value="{token}"/>
			{content}
			<div class="spacer" style="clear: both;"></div>
		</section>';

	public function setDevice($dvId) {
		$this->dvId = $dvId;
		return $this;
	}

	public function setCarrier($carrier = null) {
		$this->carrier = strtolower($carrier);
		return $this;
	}

	public function setCapacity($capacity = null) {
		$this->capacity = strtoupper($capacity);
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
		$this->init()->setCarrierSelect()->setCapacitySelect()->setApplyTypeSelect()->setDiscountTypeSelect()->setVatContainSelect()->setPlanSelect();
		return $this->getCalculator();
	}

	private function init() {
		$this->dvKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvId = %s", $this->dvId);
		
		list($dvTit ,$this->capacityCount) = DB::queryFirstList("SELECT min(dvTit), count(*) as cnt FROM tmDevice WHERE dvDisplay = 1 and dvParent = %i", $this->dvKey);

		$this->dvCate = DB::queryFirstField("SELECT dvCate FROM tmDevice WHERE dvKey = %i", $this->dvKey);

		$deviceInfo = new deviceInfo();

		//-------------------------------------------

		$this->arrCarrier = $deviceInfo->getArrCarrier($this->dvKey);
		$this->carrierCount = (int)count($this->arrCarrier);
		//var_dump($this->arrCarrier);
		if ($this->carrierCount === 1) {
			$this->lockedPropertyCount += 1;
			$this->carrier = getFirstArrKey($this->arrCarrier);
			$this->carrierLockIcon = $this->lockIcon;
		}
		$deviceInfo->setCarrier($this->carrier)->setMode($this->dvCate);

		//-------------------------------------------
		
		$this->capacityCount = (int)$this->capacityCount;
		if($this->capacityCount > 0){
			$this->dvParentKey = $this->dvKey;
			$this->dvKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvParent = %i AND dvTit = %s", $this->dvKey, $this->capacity);
		}

		if ($this->capacityCount === 1) {
			$this->lockedPropertyCount += 1;
			$this->isExistChild = true;
			$this->capacityLockIcon = $this->lockIcon;

		}
		$defaultCapacity = $dvTit;

		//-------------------------------------------

		$this->arrApplyType = $deviceInfo->getArrApplyType();
		$this->applyTypeCount = (int)count($this->arrApplyType);

		if($this->applyTypeCount == 1) {
			$this->lockedPropertyCount += 1;
			$this->applyTypeLockIcon = $this->lockIcon;
		}

		//--------------------------------------------

		$this->arrDiscountType = $deviceInfo->getArrDiscountType();
		$this->discountTypeCount = (int)count($this->arrDiscountType);

		if ($this->discountTypeCount == 1) {
			$this->lockedPropertyCount += 1;
			$this->discountTypeLockIcon = $this->lockIcon;
		}

		//-----------------------------------------
		/*
		$this->arrDeviceType = $deviceInfo->getArrDeviceType();
		$this->deviceTypeCount = (int)count($this->arrDeviceType);

		if ($this->deviceTypeCount == 1) {
			$this->lockedPropertyCount += 1;
			$this->deviceTypeLockIcon = $this->lockIcon;
		}
		*/

		//--------------------------------------------------------

		$defaultDvKey = DB::queryFirstField("SELECT dvKey FROM tmDevice WHERE dvId = %s", $this->dvId.strtolower($defaultCapacity));
		$this->arrPlan = $deviceInfo->getArrPlan($defaultDvKey);
		//var_dump($this->arrPlan);

		//---------------------------------------------------
		return $this;
	}

	public function setCarrierSelect(){
		if($this->carrierCount === 1) {
			$this->selectedCarrier = getFirstArrKey($this->arrCarrier);
		}else if(isExist($this->carrier) === true) {
			$this->selectedCarrier = $this->carrier;
		}


		if(isExist($this->selectedCarrier) === true) {
			foreach ($this->arrCarrier as $key => $val) {
				if ($key == $this->selectedCarrier) {
					$carrierChecked[$key]['isChecked'] = 'checked';
				}
			}
		}

		foreach ($this->arrCarrier as $key => $val) {
			$data['value'] = $key;
			$data['label'] = $val;
			$data['name'] = 'carrier';
			$data['isChecked'] = $carrierChecked[$key]['isChecked'];
			$data['lockIcon'] = $this->carrierLockIcon;
			$content .= getResultTemplate($data, $this->htmlPadButtonTemplate);
		}

		$data = array();
		$data['ico'] = 'carrier';
		$data['tit'] = '통신사선택';
		$data['content'] = $content;
		$data['calcRowAffix'] = ($this->carrierCount==1)?'lock-'.$this->lockedPropertyCount:$this->carrierCount;
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
		
		consoleLog($this->dvParentKey);
		$child = DB::query("SELECT * FROM tmDevice WHERE dvDisplay = 1 and dvParent = %i", (int)$this->dvParentKey);

		if($this->capacityCount === 1) {
			$this->selectedCapacity = $child[0]['dvTit'];
		}else if(isExist($this->capacity) === true) {
			$this->selectedCapacity = $this->capacity;
		}

		if(isExist($this->selectedCapacity) === true) {
			foreach ($child as $key => $val) {
				if ($val['dvTit'] == $this->selectedCapacity) {
					$child[$key]['isChecked'] = 'checked';
				}
			}
		}

		foreach ($child as $key => $val) {
			$data['label'] = $data['value'] = $val['dvTit'];
			$data['name'] = 'capacity';
			$data['isChecked'] = $val['isChecked'];
			$data['lockIcon'] = $this->capacityLockIcon;
			$content .= getResultTemplate($data, $this->htmlPadButtonTemplate);
		}
		$data = array();
		$data['ico'] = 'capacity';
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
		$data['ico'] = 'change-device';
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
		$data['ico'] = 'sale';
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
		$data['ico'] = 'vat';
		$data['tit'] = '부가세<span class="calc-vat-character"> & </span>할부이자';
		$data['content'] = $content;
		$data['calcRowAffix'] = 2;
		$this->calculatorPad .= getResultTemplate($data, $this->htmlPadWrapTemplate);
		return $this;
	}

	public function setPlanSelect(){
		$tmpDeviceInfo = new deviceInfo();
		$tmpDeviceInfo->setCarrier($this->carrier)->setMode($this->dvCate);
		$this->selectedPlan = (isExist($this->plan))?$this->plan:$this->arrPlan[getFirstArrKey($this->arrPlan)];
		//var_dump($this->arrPlan);
		//var_dump($this->selectedPlan);
		$planSelected[$this->selectedPlan] = 'selected';

		foreach ($this->arrPlan as $plan) {
			$data['value'] = $plan;
			$data['name'] = $tmpDeviceInfo->getPlanName($plan);
			$data['info'] = $tmpDeviceInfo->getPlanInfo($plan);
			$data['isSelected'] = $planSelected[$plan];
			$content .= getResultTemplate($data, $this->htmlPlanSelectOptionTemplate);
		}

		$data = array();
		$data['ico'] = 'plan';
		$data['tit'] = '요금제';
		$data['content'] = $content;
		$this->calculatorPad .= getResultTemplate($data, $this->htmlPlanSelectWrapTemplate);
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

	private function getCalculator() {
		$this->getDefaultInfo();
		$resultDevicePricePerMonth = $this->defaultInfo['dvRetailPrice'] - $this->defaultInfo['spSupport'] - $this->defaultInfo['spAddSupport'];

		if($this->selectedPlan === 21 && isContain('egg', $this->dvId) === true)
			$eventDisplay = 'style="display:none"';
		else
			$eventDisplay = '';

		$data = array(
			'dvRetailPrice' => number_format($this->defaultInfo['dvRetailPrice']),
			'isSupportRowActive' => ($this->selectedDiscountType === 'support')?'active':'',
			'spSupport' => number_format($this->defaultInfo['spSupport']),
			'spAddSupport' => number_format($this->defaultInfo['spAddSupport']),
			'resultDevicePricePerMonth' => number_format($resultDevicePricePerMonth/24),
			'planFee' => number_format($this->defaultInfo['planFee']),
			'isSelectPlanDiscountRowActive' => ($this->selectedDiscountType === 'selectPlan')?'active':'',
			'selectPlanDiscount' => number_format($this->defaultInfo['selectPlanDiscount']),
			'planFeeResult' => number_format($this->defaultInfo['planFee']-$this->defaultInfo['selectPlanDiscount']),
			'point' => number_format($this->defaultInfo['rewardPoint']),
			'totalCost' => number_format((int)$resultDevicePricePerMonth/24 + (int)($this->defaultInfo['planFee']-$this->defaultInfo['selectPlanDiscount'])),
			'eventDisplay' => $eventDisplay
		);
		$this->calculatorResult = getResultTemplate($data, $this->htmlResultWrapTemplate);
		unset($data);

		$data['content'] = $this->calculatorPad;
		$this->calculatorPad = getResultTemplate($data, $this->htmlPadTemplate);
		unset($data);

		$template = getTemplateTag();

		$data['content'] = $this->htmlPlanSelectOptionTemplate;
		$data['class'] = 'js-planSelectOptionTemplate';
		$planOptionTemplate = getResultTemplate($data, $template);
		unset($data);

		$data['content'] = $this->htmlPadButtonTemplate;
		$data['class'] = 'js-padButtonTemplate';
		$padButtonTemplate = getResultTemplate($data, $template);
		unset($data);

		$data['content'] = $this->htmlPadWrapTemplate;
		$data['class'] = 'js-padButtonTemplate';
		$padWrapTemplate = getResultTemplate($data, $template);
		unset($data);

		$data['content'] = $this->calculatorResult.$this->calculatorPad;
		$data['dvKey'] = $this->dvKey;
		$data['dvId'] = $this->dvId;
		$data['token'] = createToken();
		$calculator = getResultTemplate($data, $this->htmlCalculatorTemplate);

		return $calculator.$padWrapTemplate.$padButtonTemplate.$planOptionTemplate;

	}
}
?>