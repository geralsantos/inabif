{
  'use strict';
  moment().locale('es');
  var download = function(filename, text) {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:application/xml;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', filename);
    element.style.display = 'none';
    document.body.appendChild(element);
    element.click();
    document.body.removeChild(element);
  }
  var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="https://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name, string_html) {
    let html = '';
    if (!table.nodeType){ // no existe en el dom
      html = document.createElement('div');
      html.innerHTML = string_html;
      html.style.display = 'none';
      html.firstChild.setAttribute('id',table);
      document.body.appendChild(html);
    }
    let table_ = document.getElementById(table);
    var ctx = {worksheet: name || 'Worksheet', table: table_.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
    if (!table.nodeType) {
      document.body.removeChild(html);
    }
  }
})();
  var toLower = text => {
    return text.toString().toLowerCase();
  }
  const headersearch = (str,item) =>{
    return item[str];
  }
  var searchByName = (items, term, namesearch) => {
    if (term) {
      console.log(items, term, namesearch);
      return items.filter(item =>{
        return item[namesearch].toLowerCase().indexOf(toLower(term)) > -1;
      })
    }
    return items;
  }

  function total_meses(total, meses){

    let total_new = [], meses_new=[], data=[];
    for (var i = 0; i < meses.length; i++) {
      if (total[i]>0) {
        meses_new.push(meses[i]);
        total_new.push(total[i]);
      }
    }
    data.push(meses_new);
    data.push(total_new);
    return data;
  }

  function total_dos_datas(total){
    let data=[];
    for (var i = 0; i < total.length; i++) {
      if (total[i][1] >0 ) {
      data.push(total[i]);
      }
    }
    return data;
  }

  function romanize (num) {
    if (!+num)
        return false;
    var digits = String(+num).split(""),
        key = ["","C","CC","CCC","CD","D","DC","DCC","DCCC","CM",
               "","X","XX","XXX","XL","L","LX","LXX","LXXX","XC",
               "","I","II","III","IV","V","VI","VII","VIII","IX"],
        roman = "",
        i = 3;
    while (i--)
        roman = (key[+digits.pop() + (i * 10)] || "") + roman;
    return Array(+digits.join("") + 1).join("M") + roman;
}
function getWeekNums(momentObj) {
  var clonedMoment = moment(momentObj), first, last;

  // get week number for first day of month
  first = clonedMoment.startOf('month').week();
  // get week number for last day of month
  last = clonedMoment.endOf('month').week();

  // In case last week is in next year
  if( first > last) {
      last = first + last;
  }
  return last - first + 1;
}
function hora_min_seg(time){
  time = time *60;
  var hours = Math.floor( time / 3600 );
  var minutes = Math.floor( (time % 3600) / 60 );
  var seconds = Math.floor(time % 60);
  //Anteponiendo un 0 a los minutos si son menos de 10
  minutes = minutes < 10 ? '0' + minutes : minutes;
  //Anteponiendo un 0 a los segundos si son menos de 10
  seconds = seconds < 10 ? '0' + seconds : seconds;
  var result = hours + ":" + minutes + ":" + seconds;  // 2:41:30
  return result;
}
  document.addEventListener('DOMContentLoaded', function() {
    var type = window.location.hash.substr(1) || 'portada-index';
      appVue.changeview(type);
      window.location.hash='#'+type;
      window.onhashchange= function(){
        var type = window.location.hash.substr(1);
        appVue.changeview(type);
      }
      $('#menuToggle').click(function(){
        if ($(this).hasClass('active')) {
          $('.menu_direct').css('display','none')

        }else{
          $('.menu_direct').css('display','')
        }
      })
  })
    var isempty = function (str){
      return str ==0 || str=="0"|| str === '' || str === undefined || str === null || typeof str === undefined || typeof str == undefined || typeof str === null || str.length === 0 || str === Infinity;
    }
  var b64_to_utf8 = function ( str ) {
    return decodeURIComponent(escape(window.atob( str )));
  }

    moment.updateLocale('es', {
        months : [
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"
        ]
    });

}
