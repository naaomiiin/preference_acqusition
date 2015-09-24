
$('#input').first().focus();

var taiwa_counter=0;
var append_counter=0;

$("#append-text").click(function(){
	$('#input').first().focus();
	systemReply = "ダミー";
	taiwa_counter++;
	$('#history').animate({ scrollTop: ($('#history')[0].scrollHeight) }, 'slow');  //自動スクロール
	$('#rireki').animate({ scrollTop: ($('#rireki')[0].scrollHeight) }, 'slow');
	
	$.ajax({
		type: 'GET',
		    //url:"http://shower.human.waseda.ac.jp:3300/rating/mn-with-word2vec/replies?text="+$("#input").val(),
                    url:"http://shinzan.human.waseda.ac.jp/~itonaomi/preference_acquisition/proposed_method.php?keyword="+$("#input").val()+"&n=1", 
	            async:false,
		    dataType:"json",
		    success: function(data){
		    		    console.log("成功");
		    system = data.reply;
		    if(system === "no-result"){  //エラー処理
			systemReply = "もう１度入力してね";
		    }else{
			//systemReply = data.triple[2].text;
		        systemReply = "error";
		    }
		},
		    });
	
	    
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
				 + systemReply
			       +'</div>'
			       +'<div class="col-sm-3">'
			         +'<img src="img/pc.png" alt="システム" class="icon">'
			       +'</div>'// answer_image
			     +'</div>'// row
                             );
		
	$("#taiwa_count").text("対話回数 "+taiwa_counter+" 回");
	$("#input").val("");
	

});