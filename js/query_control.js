function submitFilter(e){
    e.preventDefault();
    var sForm = document.getElementById('house_list_form');
    var sInput = document.getElementsByClassName('house_list_filter');
    var arrayCheck = {};
    for(i = 0; i<sInput.length; i++){
        var thisName = sInput[i].getAttribute('name');
        
        if( sInput[i].value == "" || sInput[i].value == -1){
            if(thisName.indexOf('[]') != 0){
                sInput[i].style.color = 'rgba(0,0,0,0)';
                sInput[i].value = -1;
                if(isNaN(arrayCheck[thisName]))
                    arrayCheck[thisName] = 0;
                arrayCheck[thisName] += 1; 
            }else{
                sInput[i].setAttribute('disabled',true);
            }
        }
        if(thisName == 'bathroom[]'){
            console.log("sInput[i].value = "+sInput[i].value);
            console.log("arrayCheck[thisName]"+arrayCheck[thisName]);
        }
    }
    for (const property in arrayCheck) {
        var thisInput = document.getElementsByName(property);
        if(arrayCheck[property] ==thisInput.length){
            for(i = 0; i < thisInput.length ; i++){
                thisInput[i].setAttribute('disabled',true);
            }
        }
    }
    // console.log(arrayCheck);

    // alert("submitFilter");
    sForm.submit();
}