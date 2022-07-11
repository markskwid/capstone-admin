
$(document).ready(function(){
        var printContents = document.getElementById('print-this').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        window.history.go(-1); 
})
