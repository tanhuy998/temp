function validate(id ,filter, show) {    
    if(id.value != ''){
        //filter = /^[a-z][a-z0-9_\.\-]{5,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/
        if (filter.test(id.value) == true) {
            show.innerHTML = 'OK';
            show.style.color = 'Green';                                  
        }
        else
        {
            show.innerHTML = 'X';
            show.style.color = 'Red';                    
        }
    }
    else{
        show.innerHTML = '';
    }
}
function checkpass(id,confirm,show){
    if(confirm.value != ''){
        if(id.value == confirm.value){
            show.innerHTML = 'OK';
            show.style.color = 'Green';
        }
        else{
            show.innerHTML = 'X';
            show.style.color = 'Red';
        }
    }
    else{
        show.innerHTML = '';
    }
}