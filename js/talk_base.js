
$('#input').first().focus();

var taiwa_counter=0;
var append_counter=0;

$("#first").append('<br>'
                     +'<div class="row">'
                     +'<div class="blank col-sm-3">'
                     +'</div>'
                     +'<div class="arrow_answer col-sm-6" style="height:60px";>'
                     +'<br>'
                   +"あなたの趣味は？"
		     +'</div>'  
		     +'<div class="col-sm-3">'
		     +'<img src="img/pc.png" alt="システム" class="icon">'
		     +'</div>'// answer_image                                                                                                                                      
                     +'</div>'// row                                                                                                                                        
		  );

$("#apend-text").click(function(){
	$('#input').first().focus();
	//systemReply = "ダミー";
	taiwa_counter++;
//	$('#history').animate({ scrollTop: ($('#history')[0].scrollHeight) }, 'slow');  //自動スクロール
//	$('#rireki').animate({ scrollTop: ($('#rireki')[0].scrollHeight) }, 'slow');
 
    $("#history").append('<br>'
			 +'<div class="row">'
                         +'<div class="col-sm-3">'
                         +'<img src="img/girl.png" alt="ユーザー" class="icon">'
                         +'</div>'//question_image
			 +'<div class="arrow_question col-sm-6" style="height:60px";>'
                         +'<br>'
			 +$("#input").val()
			 +'</div>'
			 +'<div class="blank col-sm-3">'
                         +'</div>'
                         +'</div>'// row
                        );
    
    $("#history").append('<br>'
			 +'<div class="row">'
			 +'<div class="blank col-sm-3">'
			 +'</div>'
			 +'<div class="arrow_answer col-sm-6" style="height:60px";>'
			 +'<br>'
			 +"そうなんだ"
			 //+ systemReply
			 +'</div>'
			 +'<div class="col-sm-3">'
			 +'<img src="img/pc.png" alt="システム" class="icon">'
			 +'</div>'// answer_image
			 +'</div>'// row
                        );
    
});	

$("#taiwa_count").text("対話回数 "+taiwa_counter+" 回");
$("#input").val("");
	


