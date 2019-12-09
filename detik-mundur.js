$(document).ready(function() {
var detik = 60;
function hitung() {
setTimeout(hitung,1000);
$('#tampilkan').html( ' habis waktu ' + detik + ' detik ');
detik --;
if(detik &lt; 0) {
detik = 0;
}
}
hitung();
});