/*==========================
TOUCHY SCROLL FOR SIDEBAR
==========================*/
$("#sidebar").niceScroll({
    cursorcolor: "#2f2e2e",
    cursoropacitymax: 0.7,
    boxzoom: false,
    touchbehavior: true
});


$(function () {
	/*=========
	Mini Chart
	===========*/

	$(".line-chart").sparkline('html', {
    type: 'line',
    width: '100'+'%',
    height: '80',
    lineColor: '#e57002',
    fillColor: '#efd8c9',
    lineWidth: 2,
    spotColor: '#a02800',
    minSpotColor: '#309308',
    maxSpotColor: '#037aa5',
    spotRadius: 3,
    drawNormalOnTop: false
    });

	$(".pie-chart").sparkline('html',{
    type: 'pie',
    height: '80',
    sliceColors: ['#038ac2','#dc3912','#ff9900','#109618','#66aa00','#dd4477','#0099c6','#990099 ']});

	$(".bar-chart").sparkline('html', {
    type: 'bar',
    height: '80',
    barWidth: 8,
    barSpacing: 2,
    barColor: '#0077bc',
    negBarColor: '#ea5409',
    zeroColor: '#ff0000'});

	 $('.composite-line').sparkline('html', { fillColor: false, width: '100'+'%',
	  height: '80',
	   lineWidth: 2,
	   spotRadius: 3 });
   $('.composite-bar').sparkline('html', { type: 'bar',
     height: '80',
    barWidth: 8,
    barSpacing: 2,
	 barColor: '#aaf' });
    $('.composite-bar').sparkline([4,1,5,7,9,9,8,7,6,6,4,7,8,4,3,2,2,5,6,7],
        { composite: true, fillColor: false, lineColor: 'red' });




    $("#new-visits").sparkline('html', {
        type: 'bar',
        barColor: '#3366cc',
        height: '25'
    });

    $("#weekly-sales").sparkline('html', {
        type: 'bar',
        barColor: '#3366cc',
        height: '25'
    });
    $("#unique-visits").sparkline('html', {
        type: 'bar',
        barColor: '#3366cc',
        height: '25'
    });
    $("#weekly-visit").sparkline('html', {
        type: 'bar',
        barColor: '#3366cc',
        height: '25'
    });
    $('#weekly-visit').sparkline([4, 1, 5, 7, 9, 9], {
        composite: true,
        fillColor: false,
        lineColor: 'red'
    });
	/*colorbox*/
	$(".group1").colorbox({rel:'group1'});
	$(".portfolio a").colorbox();
	$(".group4").colorbox({rel:'group4', slideshow:true});
	$(".inline-modal").colorbox({inline:true, width:"50%"});
	$(".ajax").colorbox();
	$(".youtube").colorbox({iframe:true, innerWidth:425, innerHeight:344});
	$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	/*==Color Picker==*/
    $('.colorpicker').colorpicker();
    /*==Text Editor==*/
    $("#editor").cleditor();
	 $("#inbox-editor").cleditor({
		width:        99+'%', // width not including margins, borders or padding
          height:       500, // height not including margins, borders or padding
	 }); /*== make code pretty ==*/

	  $("#post-editor").cleditor({
		width:        99+'%', // width not including margins, borders or padding
          height:      250, // height not including margins, borders or padding
	 }); /*== make code pretty ==*/


	$('.checkall').checkAll('.tr_select input:checkbox');

	$('.checkall-user').checkAll('.tr-user-check input:checkbox');
	$('.checkall-task').checkAll('.tr-task-check input:checkbox');
	/*== make code pretty ==*/
    window.prettyPrint && prettyPrint()

	/*==Tooltip==*/
    $('.text-tip').tooltip({
        placement: 'top'
    });
	 $('.tip-top').tooltip({
        placement: 'top'
    });
	 $('.tip-bot').tooltip({
        placement: 'bottom'
    });
	 $('.tip-left').tooltip({
        placement: 'left'
    });
	 $('.tip-right').tooltip({
        placement: 'right'
    });


	/*======================
	RATY
	========================*/
    $('.star').raty({
        half: true,
        start: 3.3
    });

	   // button state demo
    $('#fat-btn')
      .click(function () {
        var btn = $(this)
        btn.button('loading')
        setTimeout(function () {
          btn.button('reset')
        }, 3000)
      })

	  $('.accordion_mnu').initMenu();
	  	/*==JQUERY SELECTBOX==*/
	$(".chzn-select").chosen();
	$(".chzn-select-deselect").chosen({allow_single_deselect: true});
	/*======================
	Tags Input
	========================*/
			$('#tags_1').tagsInput({
				width:'99%',
				'defaultText':'add a test tag'
				});
/*==JQUERY UNIFORM==*/
	$(".checkbox-b,.rem_me,.radio-b,input[type='file']").uniform();

	/*===================
	LIST-ACCORDION
	===================*/

//	$('#list-accordion').accordion({
//		header: ".title",
//		autoheight: false
//	});



		/*==INPUT MASK==*/
	$("#phone").mask("(999) 999-9999");
	$("#mobile").mask("(999) 999-9999");
	$("#tin").mask("99-9999999");
	$("#ssn").mask("999-99-9999");

$('#popover').popover();

//    $("#address").dynamicForm("#plus1", "#minus1", {
//        limit: 5
//    });
//    $("#address-form").dynamicForm("#plus2", "#minus2", {
//        limit: 5
//    });


});

/*==============================
	  NOTY TOP
	================================*/

	$('.alert_t').click(function() {

		var noty_id = noty({
			layout : 'top',
			text: 'noty - a jquery notification library!',
			modal : true,
			type:'alert',

			 });
		  });

	$('.error_t').click(function() {

		var noty_id = noty({
			layout : 'top',
			text: 'noty - a jquery notification library!',
			modal : true,
			type : 'error',
			 });
		  });

	$('.success_t').click(function() {

		var noty_id = noty({
			layout : 'top',
			text: 'noty - a jquery notification library!',
			modal : true,
			type : 'success',
			 });
		  });

	$('.info_t').click(function() {

		var noty_id = noty({
			layout : 'top',
			text: 'noty - a jquery notification library!',
			modal : true,
			type : 'information',
			 });
		  });

	$('.confirm_t').click(function() {

		var noty_id = noty({
			layout : 'top',
			text: 'noty - a jquery notification library!',
			modal : true,
			buttons: [
				{type: 'btn btn-success', text: 'Ok', click: function($noty) {

					// this = button element
					// $noty = $noty element

					$noty.close();
					noty({force: true, text: 'You clicked "Ok" button', type: 'success'});
				  }
				},
				{type: 'button btn btn-warning', text: 'Cancel', click: function($noty) {
					$noty.close();
					noty({force: true, text: 'You clicked "Cancel" button', type: 'error'});
				  }
				}
				],
			 type : 'success',
			 });

});


$(function () {
    var elf = $('#file-manager').elfinder({
        url: 'php/connector.php' // connector URL (REQUIRED)
        // lang: 'ru',             // language (OPTIONAL)
    }).elfinder('instance');
});
