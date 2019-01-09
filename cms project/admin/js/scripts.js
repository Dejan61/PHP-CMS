$(document).ready(function (){
    
        // EDITOR CKEDITOR
        ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );

        // CHECKING ALL CHECK BOXES
        $('#selectAllBoxes').click(function(event){
            if(this.checked) {
                $('.checkBoxes').each(function(){
                    this.checked = true;
                })
            } else {
                $('.checkBoxes').each(function(){
                    this.checked = false;
                })
            }
        });

        // var div_box = "<div id='load-screen'><div id='loading'></div></div>";
        // $('body').prepend(div_box);
        // $("#load-screen").delay(600).fadeOut(200, function(){
        //     $(this).remove();
        // })
});