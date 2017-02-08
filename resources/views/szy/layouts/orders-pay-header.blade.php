	<header>
		<a href=""><img src="{{App\Company::find(1)->logo2}}" alt="" class="left"></a>
		<div class="right">
			<ul>
				<li>
					<div class="step_first">			
						<div @if($payPlan>1)
								class="step_no thin-color"
							@else 
								class="step_no deep-color" 
							@endif>
							<span 
							@if($payPlan>1) 
								class="thin-color" 
							@else 
								class="deep-color" 
							@endif
							>1</span>
						</div>
						<div 
							@if($payPlan>1) 
								class="step_name f-thin-color" 
							@else 
								class="step_name f-deep-color" 
							@endif
						>1.确认订单</div>
					</div>
				</li>
				<li>
					<div class="step">
						<div @if($payPlan==1)class="step_no default-color" @endif 
							 @if($payPlan==2)class="step_no deep-color"@endif
							 @if($payPlan==3)class="step_no thin-color"@endif
						>
							<span 
							 @if($payPlan==1)class="default-color" @endif 
							 @if($payPlan==2)class="deep-color"@endif
							 @if($payPlan==3)class="thin-color"@endif
							>2</span>
						</div>
						<div 
							@if($payPlan==1)class="step_name f-default-color" @endif 
							@if($payPlan==2)class="step_name f-deep-color"@endif
							@if($payPlan==3)class="step_name f-thin-color"@endif
						>2.确定付款</div>
					</div>
				</li>
				<li>
					<div class="step_last">
						<div 
							 @if($payPlan==1)class="step_no default-color" @endif 
							 @if($payPlan==2)class="step_no default-color"@endif
							 @if($payPlan==3)class="step_no deep-color"@endif
						>
							<span 
							 @if($payPlan==1)class="default-color" @endif 
							 @if($payPlan==2)class="default-color"@endif
							 @if($payPlan==3)class="deep-color"@endif
							>3</span>
						</div>
						<div 
							@if($payPlan==1)class="step_name f-default-color" @endif 
							@if($payPlan==2)class="step_name f-default-color"@endif
							@if($payPlan==3)class="step_name f-deep-color"@endif
						>3.完成订单</div>
					</div>
				</li>
			</ul>
		</div>
	</header>