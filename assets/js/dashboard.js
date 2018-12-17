( function ( $ ) {
    "use strict";


// const brandPrimary = '#20a8d8'
const brandSuccess = '#4dbd74'
const brandInfo = '#63c2de'
const brandDanger = '#f86c6b'

function convertHex (hex, opacity) {
  hex = hex.replace('#', '')
  const r = parseInt(hex.substring(0, 2), 16)
  const g = parseInt(hex.substring(2, 4), 16)
  const b = parseInt(hex.substring(4, 6), 16)

  const result = 'rgba(' + r + ',' + g + ',' + b + ',' + opacity / 100 + ')'
  return result
}

function random (min, max) {
  return Math.floor(Math.random() * (max - min + 1) + min)
}

    var elements = 27
    var data1 = []
    var data2 = []
    var data3 = []

    for (var i = 0; i <= elements; i++) {
      data1.push(random(50, 200))
      data2.push(random(80, 100))
      data3.push(65)
    }

     //bar chart
     /*var ctx = document.getElementById( "barChart" );
     //    ctx.height = 200;
     var myChart = new Chart( ctx, {
         type: 'bar',
         data: {
             labels: [ "Indicador 1", "Indicador 2", "Indicador 3", "Indicador 4", "Indicador 5", "Indicador 6", "Indicador 8", "Indicador 9", "Indicador 10", "Indicador 11", "Indicador 12", "Indicador 13", "Indicador 14", "Indicador 15", "Indicador 16", "Indicador 17", "Indicador 18", "Indicador 19", "Indicador 20", "Indicador 21" ],
             datasets: [
                 {
                     label: "Trimestre Actual",
                     data: [ 1203, 387, 6532, 81, 1092, 2690, 5357, 1203, 387, 6532, 81, 1092, 2690, 5357, 387, 6532, 81, 1092, 2690, 5357 ],
                     borderColor: "rgba(0, 123, 255, 0.9)",
                     borderWidth: "0",
                     backgroundColor: "rgba(0, 123, 255, 0.5)"
                             },
                 {
                     label: "Trimestre Anterior",
                     data: [ 1098, 456, 6538, 106, 2000, 2783, 6523, 987,  456, 6538, 106, 2000, 2783, 6523, 987, 456, 6538, 106, 2000, 2783, 6523 ],
                     borderColor: "rgba(0,0,0,0.09)",
                     borderWidth: "0",
                     backgroundColor: "rgba(0,0,0,0.07)"
                             }
                         ]
         },
         options: {
             scales: {
                 yAxes: [ {
                     ticks: {
                         beginAtZero: true
                     }
                                 } ]
             }
         }
     } );*/
     Highcharts.chart('rpt_general_indicador', {
         chart: {
             type: 'column'
         },
         title: {
             text: 'Reporte General de Indicadores'
         },
         subtitle: {
             text: 'Trimestre Actual: OCT - NOV - DIC <br> Fecha: 13-10-2018'
         },
         xAxis: {
             categories: [
                 'Indicador 1',
                 'Indicador 2',
                 'Indicador 3',
                 'Indicador 4',
                 'Indicador 5',
                 'Indicador 6',
                 'Indicador 7',
                 'Indicador 8',
                 'Indicador 9',
                 'Indicador 10',
                 'Indicador 11',
                 'Indicador 12',
                 'Indicador 13',
                 'Indicador 14',
                 'Indicador 15',
                 'Indicador 16',
                 'Indicador 17',
                 'Indicador 18',
                 'Indicador 19',
                 'Indicador 20',
                 'Indicador 21',
             ],
             crosshair: true
         },
         yAxis: {
             min: 0,
             title: {
                 text: ''
             }
         },
         tooltip: {
             headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
             pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                 '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
             footerFormat: '</table>',
             shared: true,
             useHTML: true
         },
         plotOptions: {
             column: {
                 pointPadding: 0.2,
                 borderWidth: 0
             }
         },
         series: [{
             name: 'Trimestre Anterior',
             data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4,54.4,54.4,54.4,54.4,54.4,54.4,54.4,54.4,54.4]

         }, {
             name: 'Trimestre Actual',
             data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3,54.4,54.4,54.4,54.4,54.4,54.4,54.4,54.4,54.4]

         }]
     });
    //Traffic Chart
    var ctx = document.getElementById( "trafficChart" );
    //ctx.height = 200;
    var myChart = new Chart( ctx, {
        type: 'line',
        data: {
            labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S', 'M', 'T', 'W', 'T', 'F', 'S', 'S', 'M', 'T', 'W', 'T', 'F', 'S', 'S', 'M', 'T', 'W', 'T', 'F', 'S', 'S'],
            datasets: [
            {
              label: 'My First dataset',
              backgroundColor: convertHex(brandInfo, 10),
              borderColor: brandInfo,
              pointHoverBackgroundColor: '#fff',
              borderWidth: 2,
              data: data1
          },
          {
              label: 'My Second dataset',
              backgroundColor: 'transparent',
              borderColor: brandSuccess,
              pointHoverBackgroundColor: '#fff',
              borderWidth: 2,
              data: data2
          },
          {
              label: 'My Third dataset',
              backgroundColor: 'transparent',
              borderColor: brandDanger,
              pointHoverBackgroundColor: '#fff',
              borderWidth: 1,
              borderDash: [8, 5],
              data: data3
          }
          ]
        },
        options: {
            //   maintainAspectRatio: true,
            //   legend: {
            //     display: false
            // },
            // scales: {
            //     xAxes: [{
            //       display: false,
            //       categoryPercentage: 1,
            //       barPercentage: 0.5
            //     }],
            //     yAxes: [ {
            //         display: false
            //     } ]
            // }


            maintainAspectRatio: true,
            legend: {
                display: false
            },
            responsive: true,
            scales: {
                xAxes: [{
                  gridLines: {
                    drawOnChartArea: false
                  }
                }],
                yAxes: [ {
                      ticks: {
                        beginAtZero: true,
                        maxTicksLimit: 5,
                        stepSize: Math.ceil(250 / 5),
                        max: 250
                      },
                      gridLines: {
                        display: true
                      }
                } ]
            },
            elements: {
                point: {
                  radius: 0,
                  hitRadius: 10,
                  hoverRadius: 4,
                  hoverBorderWidth: 3
              }
          }


        }
    } );


} )( jQuery );
