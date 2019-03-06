// header-------
var height_in=document.querySelector('#input_height');
var weight_in=document.querySelector('#input_weight');
var btn_in=document.querySelector('#btn_ask');
var btn_show=document.querySelector('#btn_show');
var btn_show_descr=document.querySelector('#btn_show_descr');
var btn_show_retry=document.querySelector('#btn_show_retry');
var header=document.querySelector('#header');
var btn_retry=document.querySelector('#btn_retry');
var show_bmi=document.querySelector('#show_bmi');
// main-------
var color_out=document.querySelector('.label_color');
var abbr_out=document.querySelector('.item_abbr');
var bmi_out=document.querySelector('.result_bmi');
var weight_out=document.querySelector('.result_weight');
var height_out=document.querySelector('.result_height');
var date_out=document.querySelector('.date');
var main_items=document.querySelector('#main_items');
// 瀏覽器
var records=JSON.parse(localStorage.getItem('BMI 紀錄')) || [];

// START!!!
update();

header.addEventListener('click' , comeout , false)
function comeout(e){
    console.log(e.target.id);
    if(e.target.id == "btn_retry" || e.target.id == "img_retry"){
        btn_in.style.display='flex';
        btn_show.style.display='none';
        btn_in.textContent="在一次嗎?"
        setTimeout(function(){ btn_in.textContent="看結果";btn_in.style.fontSize ='24px' }, 2000);
        clearTimeout();
    }
    else if(e.target.id != 'btn_ask'){
        return
    }else{
        if(weight_in.value!='' && height_in.value!='' && height_in.value>0 && weight_in.value>0){
            var bmi_value= weight_in.value/Math.pow(height_in.value/100 ,2);
            bmi_value=bmi_value.toFixed(1);
            var Y=new Date(); Y=Y.getFullYear();
            var mm=new Date(); mm=mm.getMonth()+1;
            var dd=new Date(); dd=dd.getDate();
            var date_value= Y+"-"+mm+"-"+dd;
            var abbr_value='';
            var color_value='';
            if(bmi_value<18.5){
                abbr_value='過輕'
                color_value='#31BAF9'
            }else if(18.5<=bmi_value && bmi_value<24){
                abbr_value='理想'
                color_value='#86D73E'
            }else if(24<=bmi_value && bmi_value<27){
                abbr_value='過重'
                color_value='#FF982D'
            }else if(27<=bmi_value && bmi_value<30){
                abbr_value='輕度肥胖'
                color_value='#FF6C02'
            }else if(30<=bmi_value && bmi_value<35){
                abbr_value='中度肥胖'
                color_value='#FF6C02'
            }else{
                abbr_value='重度肥胖'
                color_value='#FF1200'
            }
            if (records.length>10){records.splice(0,1)};
            records.push({abbr: abbr_value, color: color_value, bmi: bmi_value, weight: weight_in.value , height: height_in.value, date: date_value });
            height_in.value='';
            weight_in.value='';
            btnchange(color_value,bmi_value,abbr_value);
            update();
        }else{
            btn_in.style.fontSize ='20pt';
            btn_in.textContent="請輸入正確數值"
            setTimeout(function(){ btn_in.textContent="看結果";btn_in.style.fontSize ='24px' }, 2000);
            clearTimeout();
        }
    }
}
function update(e){
    localStorage.setItem('BMI 紀錄', JSON.stringify(records));
    str='';
    for(var i=records.length-1 ; i>=0 ; i--){
    str +='<div class="item"><div class="label_color" style="background-color:'+records[i].color+' ;"></div><span class="item_abbr">'+records[i].abbr+'</span><span class="item_title title_bmi">BMI</span><span class="item_result result_bmi">'+records[i].bmi+'</span><span class="item_title title_weight">weight</span><span class="item_result result_weight">'+records[i].weight+'kg</span><span class="item_title title_height">height</span><span class="item_result result_height">'+records[i].height+'cm</span><span class="date">'+records[i].date+'</span></div>'
    }
    main_items.innerHTML=str;
}
function btnchange(c, b, a ){
    btn_in.style.display='none';
    btn_show.style.display='flex';
    btn_show_retry.style.borderColor=c;
    btn_show_retry.style.color=c;
    show_bmi.textContent=b;
    btn_retry.style.background=c;
    btn_show_descr.textContent=a;
    btn_show_descr.style.color=c;
}

