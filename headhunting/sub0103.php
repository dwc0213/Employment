<?
	include '../header.php';
?>
<script language='javascript'>

function charge_check() {

	corp = 0;
	$('.corp').each(function(){
		c = $(this).is(":checked");
		if(c)	corp = $(this).val();
	});
	
	corp = $("input[name=corp]:checked").val(); 

	tax = $("input[name=tax]:checked").val();

	var worker = $("#worker").val();

	if(worker<1){
		$("#worker").focus();
		alert("상시근로자수를 입력해주세요.");
		return false;
	}

	if($("input[name=corp]:checked").val() == 3.1) {
		if(worker<100){
			$("#worker").focus();
			alert("부담금 납부 대상이 아닙니다.");
			return false;
		}
	}

	else if($("input[name=corp]:checked").val() == 3.6) {
		if(worker<50){
			$("#worker").focus();
			alert("부담금 납부 대상이 아닙니다.");
			return false;
		}
	}

	var duty = Math.floor(worker * corp / 100);

	$("#duty").text(duty);
	
	var case01 = $("#case01").val();

	var case02 = $("#case02").val();
	case02 = case02 * 2

	var case_total = Number(case01) + Number(case02);

	if(case_total >= duty){
		alert("의무고용인원을 초과했습니다.");
		return false;
	}

	var workAccount = 0; 

	var worker_sum = Number(duty)-Number(case_total);
	if(worker_sum > 0){
		$("#worker_sum").val(worker_sum);
	}
	
	var unemploy = Number(duty) - Number(case_total)
	
	$("#unemploy").text(unemploy); 

	var workAccount = case_total / duty;
	
	if(workAccount<=0){
		
		
		var money_base = 1914440;

		var corptax = (((duty - case_total) * money_base) *12) * tax * 1.1		
		
		corptax = Math.floor(corptax/10) * 10;
		
		var emp_amount = (((duty - case_total) * money_base) * 12);

		var charge = corptax + emp_amount;
		$("#charge").text(charge);
		
		var solution = Math.ceil(unemploy / 2) * 2500000	
		
		$("#solution").text(solution);
		
		var samt = charge - solution;
		$("#samt").text(samt);
		
	}
	
	else if( workAccount > 0 && workAccount < 0.25 ){

		var money_base = 1608600;
		
		var corptax = (((duty - case_total) * money_base) *12) * tax * 1.1
		
		corptax = Math.floor(corptax/10) * 10;

		var emp_amount = (((duty - case_total) * money_base) * 12);

		var charge = corptax + emp_amount;
		$("#charge").text(charge);
		
		var solution = Math.ceil(unemploy / 2) * 2500000	

		$("#solution").text(solution);
		
		var samt = charge - solution;
		$("#samt").text(samt);

	}
	
	else if( workAccount >= 0.25 && workAccount < 0.50 ){
		
		var money_base = 1378800;
			
		var corptax = (((duty - case_total) * money_base) *12) * tax * 1.1

		corptax = Math.floor(corptax/10) * 10;

		var emp_amount = (((duty - case_total) * money_base) * 12);

		var charge = corptax + emp_amount;
		$("#charge").text(charge);
		
		var solution = Math.ceil(unemploy / 2) * 2500000				
		$("#solution").text(solution);
		
		var samt = charge - solution;
		$("#samt").text(samt);

	}
	
	else if( workAccount >= 0.50 && workAccount < 0.75 ){
		
		var money_base = 1217490;

		var corptax = (((duty - case_total) * money_base) *12) * tax * 1.1

		corptax = Math.floor(corptax/10) * 10;

		var emp_amount = (((duty - case_total) * money_base) * 12);

		var charge = corptax + emp_amount;
		$("#charge").text(charge);
		
		var solution = Math.ceil(unemploy / 2) * 2500000			
		$("#solution").text(solution);
		
		var samt = charge - solution;
		$("#samt").text(samt);

	}
			
	else if(workAccount < 0.75){
				
		var money_base = 1149000;

		var corptax = (((duty - case_total) * money_base) *12) * tax * 1.1

		corptax = Math.floor(corptax/10) * 10;

		var emp_amount = (((duty - case_total) * money_base) * 12);

		var charge = corptax + emp_amount;
		$("#charge").text(charge);
		
		var solution = unemploy / 2 * 2500000				
		$("#solution").text(solution);
		
		var samt = charge - solution;
		$("#samt").text(samt);

	}else if(case_total>=duty){
	
		$("#charge").text("0"); 
		$("#solution").text("0");
		$("#samt").text("0");
		$("#money_title06").val("0");
	}
	
	var duty = $("#duty").text();
	var unemploy = $("#unemploy").text();
	var charge = $("#charge").text().replace(/,/g, '');
	var solution = $("#solution").text().replace(/,/g, '');
	var samt = $("#samt").text().replace(/,/g, '');

		Number.prototype.cf=function(){
		
			var a=this.toString().split(".");
			a[0]=a[0].replace(/\B(?=(\d{3})+(?!\d))/g,",");
			return a.join(".")
		
		};

		num_count(duty, $("#duty"));
		num_count(unemploy, $("#unemploy"));
		num_count(charge, $("#charge"));
		num_count(solution, $("#solution"));
		num_count(samt, $("#samt"));

		function num_count(wcnt, obj){
			$({ val : 0 }).animate({ val : wcnt }, {
				duration: 500,
				step: function() {
					obj.text(Math.floor(this.val).cf());
				},
				complete: function() {
					obj.text(Math.floor(this.val).cf());
				}
			});
		}
		
		duty = document.getElementByID("duty").value;
}

</script>

<form name='frm01' action='/module/printSet.php' method='post'>
<input type="hidden" name="worker_sum" id="worker_sum" value="0"> 
<input type="hidden" name="worker_cnt05" id="worker_cnt05" value="0">
                                                                                                                                     
<section class="con" id="fixNextTag">
	<div class="inner">
	<div id='printime'>
		<div class="recruit">
			<h3>장애인고용부담금 계산기</h3>
			<div class="calcu">
				<table class="tbl2">
					<colgroup>
						<col width="25%">
						<col width="25%">
						<col width="50%">
					</colgroup>
					<tbody>
						<tr>
							<th colspan="3" style="border-right: none;">고용현황</th>
						</tr>
						<tr>
							<th colspan="2">기업구분</th>
							<td>
								<input id="corp01" name="corp" type="radio" value="3.1" class="corp" checked style="text-align: right;"><label for="corp01">민간기업</label>
								<input id="corp02" name="corp" type="radio" value="3.6" class="corp"><label for="corp02">공공기관</label>
							</td>
						</tr>
						<tr>
							<th colspan="2">상시 근로자수</th>
							<td>
								<input type="text" id="worker" name ="worker" value="<?=$worker?>" placeholder="상시 근로자수 입력">
								<span>명</span>
							</td>
						</tr>
						<tr>
							<th rowspan="2">장애인 근로자수</th>
							<th>심하지 않은 장애(경증)</th>
							<td>
								<input type="text" id="case01"  name="case01" value="<?=$case01?>" class="case" placeholder="고용중인 경증장애인 수 입력">
								<span>명</span>
							</td>
						</tr>
						<tr>
							<th>심한 장애(중증)</th>
							<td>
								<input type="text" id="case02"  name="case02" value="<?=$case02?>" class="case" placeholder="고용중인 중증장애인 수 입력">
								<span>명</span>
							</td>
						</tr>
						<tr>
							<th colspan="2" style="border-right: 1px solid #ddd;">법인세율</th>
							<td>
								<input id="perc01" name="tax" id="tax01" type="radio" class="tax" value="0.1"><label for="perc01">10%</label>
								<input id="perc02" name="tax" id="tax02" type="radio" class="tax" value="0.2"><label for="perc02">20%</label>
								
								<input id="perc03" name="tax" id="tax03" type="radio"  class="tax" value="0.22" checked><label for="perc03">22%</label>
								<input id="perc04" name="tax" id="tax04" type="radio" class="tax" value="0.25"><label for="perc04">25%</label>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			
			<div class="pec_chart_chk">
				[ 의무고용률, 부담기초액, 법인세율 상세보기 ]
			</div>

			<div class="chart_wrap">
				<div class="chart">
					<p>※ 의무고용률</p>
					<table class="tbl2">
						<tbody>
							<tr>
								<th colspan="2">구분</th>
								<th style="border-right: none;">2022년</th>
							</tr>
							<tr>
								<td rowspan="2" style="border-right: 1px solid #ddd;">국가 및 지자체</td>
								<td style="border-right: 1px solid #ddd;">공무원</td>
								<td>3.6%</td>
							</tr>
							<tr>
								<td style="border-right: 1px solid #ddd;">비공무원</td>
								<td>3.6%</td>
							</tr>
							<tr>
								<td colspan="2" style="border-right: 1px solid #ddd;">공공기관</td>
								<td>3.6%</td>
							</tr>
							<tr>
								<td colspan="2" style="border-right: 1px solid #ddd;">민간기업</td>
								<td>3.1%</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="chart">
					<p>※ 부담기초액</p>
					<table class="tbl2">
						<tbody>
							<tr>
								<th rowspan="2">구분</th>
								<th colspan="5" style="border-right: none;">장애인 고용의무인원 대비 고용하고 있는 장애인 근로자 비율</th>
							</tr>
							<tr>
								<th>3/4이상</th>
								<th>1/2이상<br>3/4미만</th>
								<th>1/4이상<br>1/2미만</th>
								<th>1/4미만</th>
								<th style="border-right: none;">미고용</th>
							</tr>
							<tr>
								<td style="border-right: 1px solid #ddd;">2022년 적용</td>
								<td style="border-right: 1px solid #ddd;">1,149,000원</td>
								<td style="border-right: 1px solid #ddd;">1,217,940원</td>
								<td style="border-right: 1px solid #ddd;">1,378,800원</td>
								<td style="border-right: 1px solid #ddd;">1,608,600원</td>
								<td>1,914,440원</td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<div class="chart">
					<p>※ 2022년 법인세율</p>
					<table class="tbl2">
						<tbody>
							<tr>
								<th>과세표준</th>
								<th style="border-right: none;">세율</th>
							</tr>
							<tr>
								<td style="border-right: 1px solid #ddd;">2억원 이하</td>
								<td>10%</td>
							</tr>
							<tr>
								<td style="border-right: 1px solid #ddd;">2억원 초과 ~ 200억원 이하</td>
								<td>20%</td>
							</tr>
							<tr>
								<td style="border-right: 1px solid #ddd;">200억원 초과 ~ 3,000억원 이하</td>
								<td>22%</td>
							</tr>
							<tr>
								<td style="border-right: 1px solid #ddd;">3,000억원 초과</td>
								<td>25%</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="chart_detail">
					<p style="margin-bottom:10px;">* 위 세율을 적용하여 산출된 세액에 10%의 지방세가 가산됨</p>
					<p>* 장애인고용부담금은 세법상 손금불산입에 해당되어 발생하는 세금임</p>
				</div>
				
				<div class="fold_btn">접기</div>
			</div>

			<div class="calcu_btn">
				<a href="javascript:charge_check();">부담금 조회</a>
			</div>

			<div class="calcu_result">
				<table class="tbl2">
					<colgroup>
						<col width="30%">
						<col width="70%">
					</colgroup>
					<tbody>
						<tr>
							<th colspan="2" style="border-right: none;">산출결과</th>
						</tr>
						<tr>
							<th>의무고용 장애인</th>
							<td>
								<input type="hidden"  name="duty"> 
								<span id="duty" class="price_amount">0</span>명
							</td>
						</tr>
						<tr>
							<th>고용미달 장애인</th>
							<td>
								<input type="hidden"  name="unemploy">
								<span id="unemploy" class="price_amount">0</span>명
							</td>
						</tr>
						<tr>
							<th>장애인고용부담금(연)</th>
							<td>
								<input type="hidden" name="charge">
								<span id="charge" class="price_amount">0</span>원
							</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align: center;">
								<p style="margin-bottom:10px;">· 법인세, 지방세 포함 기준</p>
								<p>·  중증장애인 2배수제 적용 기준</p>
							</td>
						</tr>
					</tbody>
				</table>
				<table class="tbl2" style="margin-top:30px;">
					<colgroup>
						<col width="30%">
						<col width="70%">
					</colgroup>
					<tbody>
						<tr>
							<th colspan="2" style="border-top: 1px solid #ddd;">채용대행 솔루션 도입시 절감 금액 확인</th>
						</tr>
						
						<tr>
							<th>솔루션 도입비용(1회성)</th>
							<td>
								<input type="hidden" name="solution">
								<span id="solution" class="price_amount">0</span>원
							</td>
						</tr>

						<tr>
							<th>장애인고용부담금 절감금액</th>
							<td>
								<input type="hidden" name="samt">
								<span id="samt" class="price_amount">0</span>원
							</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align: center;">
								<p style="margin-bottom:10px;">· 중증장애인 재택근무 채용대행 기준임(기타 근무형태 협의)</p>
								<p>· 장애인 채용 및 컨설팅 솔루션은 별도 문의</p>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
				<div class="print_btn">
					<a href="javascript:tmpChk();">결과물 출력</a>
				</div>
				<div class="ch_btn">
					<a href="https://ablejob.co.kr/headhunting/sub0102.php" target='_blank'>채용대행문의</a>
				</div>
			</div>
		</div>
	</div>
</section>
</form>

<script>

function tmpChk(){
	form = document.frm01;
	form.corp.value = $('.corp:checked').val();
	form.worker.value = $('#worker').val();
	form.case01.value = $('#case01').val();
	form.case02.value = $('#case02').val();
	form.tax.value = $('.tax:checked').val();
	form.duty.value = $('#duty').text();
	form.unemploy.value = $('#unemploy').text();
	form.solution.value = $('#solution').text();
	form.charge.value = $('#charge').text();
	form.samt.value = $('#samt').text();
	form.href = '/module/printSet.php';
	form.target = '_blank';
	form.submit();

}

</script>

<style>
	.tbl2 tr:last-child td {
		background: transparent;
	}
	.calcu_btn {
		background: #0f298f;
		color: #fff;
		margin: 50px auto 50px;
		width: 160px;
		height: 40px; 
		line-height: 40px;
		cursor: pointer;
		letter-spacing: -0.025em;
		font-size: 16px;
		text-align: center;
	}

	.recruit input[type="text"] {width: 60%; text-align: right;}
	table td span {display: inline-block; width: 10%; margin-left: 2%; text-align: right; box-sizing: border-box; padding-right: 10px;}
	table td span.price_amount {width: 60%;}
	.pec_chart_chk {color:#0f298f; text-align: center; box-sizing: border-box; margin: 20px auto; width: 310px; font-weight: 700; cursor: pointer;}
	.pec_chart_chk:hover {border-bottom: 1px solid #0f298f;}
	.chart_wrap {display:none; border-bottom: 2px solid #ddd;}
	.chart {margin-bottom: 30px;}
	.chart p {margin-bottom: 10px; font-weight: 700;}
	.chart table td {text-align:center;}
	.fold_btn {
		background: #666;
		color: #fff;
		margin: 50px auto;
		width: 160px;
		height: 40px; 
		line-height: 40px;
		cursor: pointer;
		letter-spacing: -0.025em;
		font-size: 16px;
		text-align: center;
	}
	
	.print_btn {
		background: #0f298f;
		color: #fff;
		margin: 50px 36px 50px 300px;
		width: 160px;
		height: 40px; 
		line-height: 40px;
		cursor: pointer;
		letter-spacing: -0.025em;
		font-size: 16px;
		text-align: center;
		display: inline-block;
		
	}

	.ch_btn {
		background: #0f298f;
		color: #fff;
		margin-right:80px;
		width: 160px;
		height: 40px; 
		line-height: 40px;
		cursor: pointer;
		letter-spacing: -0.025em;
		font-size: 16px;
		text-align: center;
		display: inline-block;
		:hover{opacity:0.9; transition:0.1s;}
		{background:#0f298f; color:#fff;}
	}

</style>


<script>
	    $(".pec_chart_chk").click(function(){
			
			$(".chart_wrap").stop().slideDown();

		 });

	    $(".fold_btn").click(function(){
			
			$(".chart_wrap").stop().hide();

		 });

</script>

<?
	include '../footer.php';
?>



<?
	include '../footer2.php';
?>
