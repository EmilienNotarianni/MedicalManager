$(document).ready(function () {
  $('[data-toggle=offcanvas]').click(function () {
    $('.row-offcanvas').toggleClass('active')
  });
});


function displayCompagnies(tab) {
	var htmlCode = document.getElementById("cnt");
		htmlCode.innerHTML +='<TABLE BORDER="1"> 
			<CAPTION> <h4> Enseignements de 1ère année <h4> </caption>
				<TR> 
					<TH> Code </TH> 
					<TH> Type </TH> 
					<TH> Dénomination </TH> 
				</TR>'");"


	for (var i = 0, c = tab.length; i < c; i++) {
		htmlCode.innerHTML +=""
}