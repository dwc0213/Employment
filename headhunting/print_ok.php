<?
	$corp = $_POST['corp'];
	$worker = $_POST['worker'];
	$case01 = $_POST['case01'];
	$case02 = $_POST['case02'];
	$tax = $_POST['tax'];
	$duty = $_POST['duty'];
	$unemploy = $_POST['unemploy'];
	$charge = $_POST['charge'];
	$solution = $_POST['solution'];
	$samt = $_POST['samt'];

	if($corp == '3.1'){

		$corp = '민간기업';

	}else if($corp == '3.6'){

		$corp = '공공기관';

	}

	if($tax == '0.1'){

		$tax = '10';

	}else if($tax == '0.2'){

		$tax = '20';

	}else if($tax == '0.22'){

		$tax = '22';

	}else if($tax == '0.25'){

		$tax = '25';

	}
?>

<script language='javascript'>

function charge_check() {
	//form = document.frm01;

	corp = 0;

/*1. 첫번째 제이쿼리 라디오 선택자
	$('.corp').each(function(){
		c = $(this).is(":checked");
		if(c)	corp = $(this).val();
	});
*/

/*	2. 두번째 제이쿼리 선택자
	if($('#corp01').is(":checked"))		corp = $('#corp01').val();
	else if($('#corp02').is(":checked"))	corp = $('#corp02').val();
*/

//	3. 세번째 제이쿼리 선택자(이름)
//	corp = $('input[name=corp]:checked').val();

	//4. 네번쨰 제이쿼리 선택자(클래스)
	//민간사업자, 공공기관 중 선택
	corp = $('.corp:checked').val(); 
	
		alert(corp);
	
	//법인세율 라디오 박스 선택
	tax = $('.tax:checked').val();
	
		alert(tax);

	//상시 근로자의 value값 가져오기
	var worker = $("#worker").val();
	
	//전체 근로자수가 1보다 작으면 mo_count의 아이디쪽으로 돌아가서 커서를 깜빡이게 해주고 alert을 띄운다.
	// return false 모든행동을 멈춘다라는 뜻
	if(worker<1){
		$("#worker").focus()
		alert("상시근로자수를 입력해주세요.");
		return false;
	}

	//의무고용인원 (상시 근로자수 * 3.1(기업구분) / 100)
	//parseInt 첫번째 인자를 문자열을 숫자로 변환 그값을 파싱해서 정순 NaN을 반환한다
	var duty = Math.floor(worker * corp / 100);

	//의무고용 장애인 출력
	$("#duty").text(duty);

	//경증장애인
	var case01 = $("#case01").val();

	//중증장애인
	var case02 = $("#case02").val();
	case02 = case02 * 2

	//총 장애인수(중증가산)
	var case_total = Number(case01) + Number(case02);

	//총 장애인수가 의무고용인원보다 크거나 같으면 alert 경고창을 띄우고 모든행동을 멈춘다.
	if(case_total >= duty){
		alert("의무고용인원을 초과했습니다.");
		return false;
	}
	
	//workAccount 초기화
	var workAccount = 0; 

	//계(의무고용인원 - 중증가산인원) 이 0보다 크면 (의무고용인원 - 중증가산인원)
	var worker_sum = Number(duty)-Number(case_total);
	if(worker_sum > 0){
		$("#worker_sum").val(worker_sum);
	}
	
	//미고용장애인 = 의무고용의원 - 총장애인(중증가산)
	var unemploy = Number(duty) - Number(case_total)
	
	// 고용미달 장애인 출력
	$("#unemploy").text(unemploy); 

	//workAccount(부담기초액) 변수에 총장애인근로자 / 의무고용인원
	var workAccount = case_total / duty;
	
	//부담기초액 산식 'B' = 0
	if(workAccount<=0){
		
		//기준금액 2021
		var money_base = 1914440;

		//법인세 = (의무고용장애인 - 총 고용장애인) * 부담기초액 * 12(1년) * 법인세율 * 1.1
		//법인세 = (duty - case_total) * money_base) *12) * tax * 1.1
		var corptax = (((duty - case_total) * money_base) *12) * tax * 1.1		
		
		//소수점 내리고 정수도 내림
		corptax = Math.floor(corptax/10) * 10;
		
		//alert(corptax);

		//장애인 고용부담금 = 의무고용장애인 - 총고용장애인 * 부담기초액 *12
		var emp_amount = (((duty - case_total) * money_base) * 12);

		// 장애인 고용부담금(연) = 법인세 + 장애인 고용부담금
		var charge = corptax + emp_amount;
		$("#charge").text(charge);
		
		//솔루션 도입비용 = 고용미달 장애인수 ÷ 2 * 2,500,000원
		var solution = Math.ceil(unemploy / 2) * 2500000	
		
		$("#solution").text(solution);
		
		//장애인고용부담금 절감금액 = 장애인 고용부담금(연) - 솔루션 도입비용
		var samt = charge - solution;
		$("#samt").text(samt);
		
	}
	
	//부담기초액 산식 = 총장애인근로자 / 의무고용인원 > 0  && 총장애인근로자 / 의무고용인원 < 25% 1,608,600원
	else if( workAccount > 0 && workAccount < 0.25 ){

		//기준금액 2022
		var money_base = 1608600;
		
		//법인세 = (의무고용장애인 - 총 고용장애인) * 부담기초액 * 12(1년) * 법인세율 * 1.1
		//법인세 = (duty - case_total) * money_base) *12) * tax * 1.1
		var corptax = (((duty - case_total) * money_base) *12) * tax * 1.1
		
		//소수점 내리고 정수도 내림
		corptax = Math.floor(corptax/10) * 10;

		//장애인 고용부담금 = 의무고용장애인 - 총고용장애인 * 부담기초액 *12
		var emp_amount = (((duty - case_total) * money_base) * 12);

		// 장애인 고용부담금(연) = 법인세 + 장애인 고용부담금
		var charge = corptax + emp_amount;
		$("#charge").text(charge);
		
		//솔루션 도입비용 = 고용미달 장애인수 ÷ 2 * 2,500,000원
		var solution = Math.ceil(unemploy / 2) * 2500000	

		$("#solution").text(solution);
		
		//장애인고용부담금 절감금액 = 장애인 고용부담금(연) - 솔루션 도입비용
		var samt = charge - solution;
		$("#samt").text(samt);

	}

	//부담기초액 산식 총장애인근로자 / 의무고용인원 >= 25% && 총장애인근로자 / 의무고용인원 < 50% 1,378,800원
	else if( workAccount >= 0.25 && workAccount < 0.50 ){
		
		//기준금액 2022
		var money_base = 1378800;
			
		//법인세 = (의무고용장애인 - 총 고용장애인) * 부담기초액 * 12(1년) * 법인세율 * 1.1
		//법인세 = (duty - case_total) * money_base) *12) * tax * 1.1
		var corptax = (((duty - case_total) * money_base) *12) * tax * 1.1

		//소수점 내리고 정수도 내림
		corptax = Math.floor(corptax/10) * 10;

		//장애인 고용부담금 = 의무고용장애인 - 총고용장애인 * 부담기초액 *12
		var emp_amount = (((duty - case_total) * money_base) * 12);

		// 장애인 고용부담금(연) = 법인세 + 장애인 고용부담금
		var charge = corptax + emp_amount;
		$("#charge").text(charge);
		
		//솔루션 도입비용 = 고용미달 장애인수 ÷ 2 * 2,500,000원
		var solution = Math.ceil(unemploy / 2) * 2500000				
		$("#solution").text(solution);
		
		//장애인고용부담금 절감금액 = 장애인 고용부담금(연) - 솔루션 도입비용
		var samt = charge - solution;
		$("#samt").text(samt);

	}

	//부담기초액 산식 의무고용인원/장애인근로자수 >= 50% && 의무고용인원/장애인근로자수 < 75% 1,217,490원
	else if( workAccount >= 0.50 && workAccount < 0.75 ){
		
		//기준금액 2022
		var money_base = 1217490;

		//법인세 = (의무고용장애인 - 총 고용장애인) * 부담기초액 * 12(1년) * 법인세율 * 1.1
		//법인세 = (duty - case_total) * money_base) *12) * tax * 1.1
		var corptax = (((duty - case_total) * money_base) *12) * tax * 1.1

		//소수점 내리고 정수도 내림
		corptax = Math.floor(corptax/10) * 10;

		//장애인 고용부담금 = 의무고용장애인 - 총고용장애인 * 부담기초액 *12
		var emp_amount = (((duty - case_total) * money_base) * 12);

		// 장애인 고용부담금(연) = 법인세 + 장애인 고용부담금
		var charge = corptax + emp_amount;
		$("#charge").text(charge);
		
		//솔루션 도입비용 = 고용미달 장애인수 ÷ 2 * 2,500,000원
		var solution = Math.ceil(unemploy / 2) * 2500000			
		$("#solution").text(solution);
		
		//장애인고용부담금 절감금액 = 장애인 고용부담금(연) - 솔루션 도입비용
		var samt = charge - solution;
		$("#samt").text(samt);

	}
			
	//부담기초액 산식 의무고용인원/장애인근로자수
	else if(workAccount < 0.75){
				
		//기준금액 2022
		var money_base = 1149000;

		//법인세 = (의무고용장애인 - 총 고용장애인) * 부담기초액 * 12(1년) * 법인세율 * 1.1
		//법인세 = (duty - case_total) * money_base) *12) * tax * 1.1
		var corptax = (((duty - case_total) * money_base) *12) * tax * 1.1

		//소수점 내리고 정수도 내림
		corptax = Math.floor(corptax/10) * 10;

		//장애인 고용부담금 = 의무고용장애인 - 총고용장애인 * 부담기초액 *12
		var emp_amount = (((duty - case_total) * money_base) * 12);

		// 장애인 고용부담금(연) = 법인세 + 장애인 고용부담금
		var charge = corptax + emp_amount;
		$("#charge").text(charge);
		
		//솔루션 도입비용 = 고용미달 장애인수 ÷ 2 * 2,500,000원
		var solution = unemploy / 2 * 2500000				
		$("#solution").text(solution);
		
		//장애인고용부담금 절감금액 = 장애인 고용부담금(연) - 솔루션 도입비용
		var samt = charge - solution;
		$("#samt").text(samt);

	}else if(case_total>=duty){
			
				$("#charge").text("0");//연간 발생되는 장애인 고용부담금
				$("#solution").text("0"); //솔루션 도입비용(1회성)
				$("#samt").text("0"); // 장애인 고용부담금 절감금액

				$("#money_title06").val("0");

	}

	var duty = $("#duty").text(); //의무고용인원 문자열 출력
	var unemploy = $("#unemploy").text(); // 고용미달장애인
	var charge = $("#charge").text().replace(/,/g, ''); // 연간 발생되는 장애인 고용부담금
	var solution = $("#solution").text().replace(/,/g, ''); // 솔루션 도입비용(1회성)
	var samt = $("#samt").text().replace(/,/g, ''); // 장애인 고용부담금 절감금액

		Number.prototype.cf=function(){
		
			var a=this.toString().split("."); //. 으로 String객체를 문자열로 나누고
			a[0]=a[0].replace(/\B(?=(\d{3})+(?!\d))/g,","); // 정규식으로 문자열 반환해서 콤마로 변경하고
			return a.join(".") // 마지막에 다시 .붙이고 
		
		};

		num_count(duty, $("#duty")); // 의무 고용인원
		num_count(unemploy, $("#unemploy")); //미달 고용 장애인
		num_count(charge, $("#charge")); // 연갈 발생되는 장애인 고용부담금
		num_count(solution, $("#solution")); // 솔루션 도입비용(1회성)
		num_count(samt, $("#samt")); // 장애인 고용부담금 절감금액

		//애니메이션 효과주기 animate
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
			
}

</script>





<style>
@page {
            size: A4;
            margin: 0.7cm;
            /*size: landscape;*/
        }
        @media print {
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }

         table { page-break-inside:avoid;page-break-after:auto }
         tr    { page-break-inside:avoid; page-break-after:auto }
         td    { page-break-inside:avoid; page-break-after:auto }
         thead { display:table-header-group }
         tfoot { display:table-footer-group }


        }


	table {margin:0; padding:0; border:0; outline:0; text-decoration:none; border-collapse:collapse;border-spacing:0;}
	.recruit{margin:20px auto 40px;}
	.recruit input[type="text"] {width: 60%; padding: 5px 0; height: 30px;}
	input[type="text"] {border:1px solid #ddd;}
	.recruit h3{color:#212121; font-size:24px; font-weight:500; letter-spacing:-0.025em; line-height:120%; margin-bottom:16px;}
	.tbl2{width:100%; border-top:2px solid #0f298f; table-layout:fixed;}
	.tbl2 th,
	.tbl2 td{padding:10px 16px; border-bottom:1px solid #ddd; word-break:keep-all;}
	.tbl2 tr:last-child th,
	.tbl2 tr:last-child td{background:#f5f5f5; border-right:0;}
	.tbl2 th{color:#333; font-size:16px; font-weight:500; letter-spacing:-0.025em; background:#f5f5f5; border-right:1px solid #ddd;}
	.tbl2 td{color:#666; font-size:15px; letter-spacing:-0.025em;}
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

	.recruit input[type="text"] {width: 60%;}
	table td span {display: inline-block; width: 20%; margin-left: 2%;}
	/* .pec_chart_chk {color:#0f298f; text-align: center; box-sizing: border-box; margin: 20px auto; width: 310px; font-weight: 700; cursor: pointer;} */
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

</style>

<section class="con" id="fixNextTag">
	<div class="inner">
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
								<input id="pers" type="text" value="<?=$corp?>" style="text-align:center;"><!-- <label for="pers">민간기업</label> -->
								<!-- <input id="public" type="radio" value="<?=$corp?>"><label for="public">공공기관</label> -->
							</td>
						</tr>
						<tr>
							<th colspan="2">상시 근로자수</th>
							<td>
								<input type="text" value="<?=$worker?>" style="text-align:right;">
								<span>명</span>
							</td>
						</tr>
						<tr>
							<th rowspan="2">장애인 근로자수</th>
							<th>심하지 않은 장애(경증)</th>
							<td>
								<input type="text" value="<?=$case01?>" style="text-align:right;">
								<span>명</span>
							</td>
						</tr>
						<tr>
							<th>심한 장애(중증)</th>
							<td>
								<input type="text" value="<?=$case02?>" style="text-align:right;">
								<span>명</span>
							</td>
						</tr>
						<tr>
							<th colspan="2" style="border-right: 1px solid #ddd;">법인세율</th>
							<td>
								<input id="perc01" name="tax" id="tax01" type="text" class="tax" value="<?=$tax?>" style="text-align:right;">%<!-- <label for="perc01">10%</label> -->
								<!-- <input id="perc02" name="tax" id="tax02" type="radio" class="tax" value="<?=$tax?>"><label for="perc02">20%</label>
								------------최초 22%에 checked 되어있어야 함---------
								<input id="perc03" name="tax" id="tax03" type="radio"  class="tax" value="<?=$tax?>"><label for="perc03">22%</label>
								<input id="perc04" name="tax" id="tax04" type="radio" class="tax" value="<?=$tax?>"><label for="perc04">25%</label> -->
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<!--------------------=========여기서부터 뺀거..===========---------------------->

<!-- 			<div class="pec_chart_chk">
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
				</div> -->


			<!--------------------=========여기서까지 뺀거..===========---------------------->

				<div class="chart_detail">
					<p style="margin-bottom:10px;">* 위 세율을 적용하여 산출된 세액에 10%의 지방세가 가산됨</p>
					<p>* 장애인고용부담금은 세법상 손금불산입에 해당되어 발생하는 세금임</p>
				</div>
				
				<!-- <div class="fold_btn">접기</div> -->
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
								<input type="text" value="<?=$duty?>" style="text-align:right;">
								<span >명</span>
							</td>
						</tr>
						<tr>
							<th>고용미달 장애인</th>
							<td>
								<input type="text" value="<?=$unemploy?>" style="text-align:right;">
								<span class="price_amount">명</span>
							</td>
						</tr>
						<tr>
							<th>장애인고용부담금(연)</th>
							<td>
								<input type="text" value="<?=$charge?>" style="text-align:right;">
								<span class="price_amount">원</span>
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
								<input type="text" value="<?=$solution?>" style="text-align:right;">
								<span class="price_amount">원</span>
							</td>
						</tr>

						<tr>
							<th>장애인고용부담금 절감금액</th>
							<td>
								<input type="text" value="<?=$samt?>" style="text-align:right;">
								<span class="price_amount">원</span>
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
		</div>
	</div>
</section>