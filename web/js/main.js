// $(document).ready(function(){
    
//     setInterval(function(){
//         remain_bv = remain_bv - 1;
//         parseTime_bv(remain_bv);
//         if(remain_bv <= 0){
//             alert('Time is over');
//         }
//     }, 1000);
            
//     //Time
//     var remain_bv   = 7200;
//     function parseTime_bv(timestamp){
//         if (timestamp < 0) timestamp = 0;
        
//         var hour = Math.floor(timestamp/60/60);
//         var mins = Math.floor((timestamp - hour*60*60)/60);
//         var secs = Math.floor(timestamp - hour*60*60 - mins*60); 
//         var left_hour = Math.floor( (timestamp) / 60 / 60 );

//         $('.afss_hours_bv').text(left_hour);
        
//         $('.afss_mins_bv').text(
//             String(mins).length > 1 ? mins : "0" + mins
//         );
//         $('.afss_secs_bv').text(
//             String(secs).length > 1 ? secs : "0" + secs
//         );
//     }
    
//     //Hide block
//     $('#test_button').on('click', function(){
//        $('#hidden_content').toggle(); 
//     });
    
//     $('#exam_button').on('click', function(){
//        $('#hidden_content_2').toggle(); 
//     });
    
//     //Hide password
//     $('#checkPassword').on('click', function(){ 
//         if(this.checked)  {
//            $('#input_password').attr('type','text');
//            $('.icon_pass').css('color','#007aff')
//        } else {
//             $('#input_password').attr('type','password');
//            $('.icon_pass').css('color','#8e8e93');
//         }
//     });

//     //ajax
//     $('.btn_answer').click(function(){
//         var form = $(this).closest('form');
//         $.post(form.attr('action'), form.serialize())
//             .done(function(){
//             //Next question
//                 $('#right_arrow').click();
//             //Progress bar
//                 $('#htmlprogress').append(' <div class="progress-bar progress-bar-success" role="progressbar" style="width:10%">1</div>');
//             //ball
//             })
//             .fail(function(){
//                 alert("Something went wrong.");
//         });
//     });
// });
 