
$('#your_name').first().focus();

var taiwa_counter = 0;
var append_counter = 0;
var unknown_sentence = "";
var number = 1;

$(document).ready(function() {
    $("input[type='text']").keypress(function(ev) {
	if ((ev.which && ev.which === 13) || (ev.keyCode && ev.keyCode === 13)) {
	    return false;
	} else {
	    return true;
	}
    });
});

$("#append-text").click(function(){
    $('#input').first().focus();
    var sentence=$("#input").val();
    var name=$("#your_name").val();
    $(':hidden[name="name"]').val(name);

    
    systemReply = "そうなんですね。他の趣味はありますか？";
    taiwa_counter++;
    $('#history').animate({ scrollTop: ($('#history')[0].scrollHeight) }, 'slow');  //自動スクロール
    
    if($("#input").val()==="わかりません"){
	number++;
	sentence = $(':hidden[name="noun"]').val();
	unknown_sentence = $(':hidden[name="wakarimasen"]').val("わかりません");
	var wakarimasen = document.getElementById('wakarimasen').value;	
	
    }else if($("#input").val()===""){
        taiwa_counter--;
    }else{
	number=1;
    }

    if(taiwa_counter===10){
        $(function(){
            $('#hide').show();
        });
    };

    $(function(){
        $('#your_name').hide();
    });

    var idf = "";
    var m = location.search.match(/user_name=([0-9a-z]+)/i);

    if(taiwa_counter===1){
	$.ajax({
	    type: 'GET',
	    url:"http://shinzan.human.waseda.ac.jp/~itonaomi/preference_acquisition/ntt_proposed_method.php",
	    async:false,
	    dataType:"json",
	    data: {                                                                                                                                                                                                                                         
		'wakarimasen' : wakarimasen,                                                                                                                                                                                                               
		'keyword': sentence,
		'n':number,
		'user_name':m[1]
	    },  
	    success: function(data){
		console.log(">>XS成功");
		systemReply = data.reply;
		console.log(data[data.length - 1]);
		
		if(data[data.length - 1].condition === "ok"){  //エラー処理
		    systemReply = data[data.length - 1].reply;
		    $(':hidden[name="noun"]').val(sentence);
		    var previous_idf = $(':hidden[name="previous_idf"]').val(data[data.length - 1].idf);
		    previous_idf = document.getElementById('previous_idf').value;
		    console.log(">>>>>"+previous_idf);
		}else if($("#input").val()===""){
		    systemReply = "何か入力してください";
		}else{
		    systemReply = "そうなんですね。他の趣味はありますか？";
		}
	    },
	    error: function(data){
		console.log("apiサーバでエラー発生");
		console.log(data);
	    }
	});
    }else{    // 対話回数2回目以降
	previous_idf = document.getElementById('previous_idf').value;
	$.ajax({
            type: 'GET',
            url:"http://shinzan.human.waseda.ac.jp/~itonaomi/preference_acquisition/ntt_proposed_method.php",
            async:false,
            dataType:"json",
            data: {
		'previous_idf': previous_idf,
		'wakarimasen' : wakarimasen,
		'keyword': sentence,
		'n':number,
		'user_name':m[1]
            },
            success: function(data){
		console.log(">>XS成功");
		systemReply = data.reply;
		console.log(data[data.length - 1]);

		if(data[data.length - 1].condition === "ok"){  //エラー処理                                                                                                                                                                                  
                    systemReply = data[data.length - 1].reply;
                    $(':hidden[name="noun"]').val(sentence);
                    var previous_idf = $(':hidden[name="previous_idf"]').val(data[data.length - 1].idf);
                    previous_idf = document.getElementById('previous_idf').value;
		    console.log(">>>>>"+previous_idf);
		}else if($("#input").val()===""){
                    systemReply = "何か入力してください";
		}else{
		    systemReply = "そうなんですね。他の趣味はありますか？";
		}
            },
            error: function(data){
		console.log("apiサーバでエラー発生");
		console.log(data);
	    }
	});
    }
    



    $("#history").append('<br>'
			 +'<div class="row">'
                         +'<div class="col-sm-3">'
                         +'<img src="img/girl.png" alt="ユーザー" class="girl_icon">'
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
			 +'</br>'
			 +'<div>'
			 +'<img src="img/line.png" alt="ライン">'			     
			 +'</div>'     
			);
    
    $.ajax({
        type: 'POST',
        dataType:'json',
        url:'receive_ntt_proposed_method.php',
	data:{
	    name: name,
            user: $("#input").val(),
            system: systemReply,
            idf: idf
	},
        success:function(data) {
            alert(data);
	},
        error:function(XMLHttpRequest, textStatus, errorThrown) {

        }
    });



    $("#taiwa_count").text("対話回数 "+taiwa_counter+" 回");
    $("#input").val("");
    

});