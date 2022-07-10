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
	corp = $('.corp:checked').val(); 
	
		alert(corp);
	
	tax = $('.tax:checked').val();
	
		alert(tax);

	var worker = $("#worker").val();
	
	if(worker<1){
		$("#worker").focus()
		alert("상시근로자수를 입력해주세요.");
		return false;
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
			return a.join(".");
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
								<input id="perc01" name="tax" id="tax01" type="text" class="tax" value="<?=$tax?>" style="text-align:right;">%
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="chart_detail">
				<p style="margin-bottom:10px;">* 위 세율을 적용하여 산출된 세액에 10%의 지방세가 가산됨</p>
				<p>* 장애인고용부담금은 세법상 손금불산입에 해당되어 발생하는 세금임</p>
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
