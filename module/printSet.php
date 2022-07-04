<?
	include "../module/class/class.Msg.php";
	include "../module/class/class.DbCon.php";
?>

<link type='text/css' rel='stylesheet' href='./print.css'>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link type='text/css' rel='stylesheet' href='/css/style.css'>
<link type='text/css' rel='stylesheet' href='/css/button.css'>
<script language="javascript" type="text/javascript">

function printPage() {
	if(window.print){
		agree = confirm('현재 페이지를 출력하시겠습니까?');
		if (agree) window.print();
	}
}

</script> 

<body onload='printPage();'>

<style type="text/css" media="print">
@page {
    size: auto;  /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
</style>


<!--<div id="wrap" style="page:a4sheet;page-break-after:always;">-->
<div id="wrap">

	<?
		include '../headhunting/print_ok.php';
	?>

</div>

<!--

<div onclick="javascript:printPage(uid)" style='width:200px;height:50px;line-height:50px;text-align:center;margin:50px auto;background:#4d56c3;color:#ffffff;font-size:18px;font-weight:bold;cursor:pointer;margin-bottom:0'>인쇄</div>
<br>
<div style='text-align:Center;'>
	※ 익스플로러에서 간혹적으로 인쇄가 안되시는 분들은 Chrome 에서 인쇄해주시기 바랍니다.
</div>
-->
<br><br>
