function addToLatlng(address){ //주소를 좌표로 변환
    var geocoder = new kakao.maps.services.Geocoder();
    var coords;

    geocoder.addressSearch(address,function(result,status){
        if (status === kakao.maps.services.Status.OK) 
            coords = new kakao.maps.LatLng(result[0].y, result[0].x);
    })
    return coords;
}





// php chr() 대응
if (typeof chr == "undefined") {
    function chr(code) {
        return String.fromCharCode(code);
    }
}