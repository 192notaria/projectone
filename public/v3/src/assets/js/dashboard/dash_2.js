// var chart1
// window.addEventListener("load", function(){
//   try {

//     getcorkThemeObject = localStorage.getItem("theme");
//     getParseObject = JSON.parse(getcorkThemeObject)
//     ParsedObject = getParseObject;

//     if (ParsedObject.settings.layout.darkMode) {

//       var Theme = 'dark';

//       Apex.tooltip = {
//           theme: Theme
//       }

//       /**
//           ==============================
//           |    @Options Charts Script   |
//           ==============================
//       */

//       /*
//           =============================
//               Daily Sales | Options
//           =============================
//       */
//       var d_2options1 = {
//         chart: {
//             height: 160,
//             type: 'bar',
//             stacked: true,
//             stackType: '100%',
//             toolbar: {
//                 show: false,
//             }
//         },
//         dataLabels: {
//             enabled: false,
//         },
//         stroke: {
//             show: true,
//             width: [3, 4],
//             curve: "smooth",
//         },
//         colors: ['#e2a03f', '#e0e6ed'],
//         series: [{
//             name: 'Sales',
//             data: [44, 55, 41, 67, 22, 43, 21]
//         },{
//             name: 'Last Week',
//             data: [13, 23, 20, 8, 13, 27, 33]
//         }],
//         xaxis: {
//             labels: {
//                 show: false,
//             },
//             categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'],
//             crosshairs: {
//             show: false
//             }
//         },
//         yaxis: {
//             show: false
//         },
//         fill: {
//             opacity: 1
//         },
//         plotOptions: {
//             bar: {
//                 horizontal: false,
//                 columnWidth: '25%',
//                 borderRadius: 8,
//             }
//         },
//         legend: {
//             show: false,
//         },
//         grid: {
//             show: false,
//             xaxis: {
//                 lines: {
//                     show: false
//                 }
//             },
//             padding: {
//             top: -20,
//             right: 0,
//             bottom: -40,
//             left: 0
//             },
//         },
//         responsive: [
//             {
//                 breakpoint: 575,
//                 options: {
//                     plotOptions: {
//                         bar: {
//                             borderRadius: 5,
//                             columnWidth: '35%'
//                         }
//                     },
//                 }
//             },
//         ],
//       }

//       /*
//           =============================
//               Total Orders | Options
//           =============================
//       */
//       var d_2options2 = {
//         chart: {
//           id: 'sparkline1',
//           group: 'sparklines',
//           type: 'area',
//           height: 290,
//           sparkline: {
//             enabled: true
//           },
//         },
//         stroke: {
//             curve: 'smooth',
//             width: 2
//         },
//         fill: {
//           type:"gradient",
//           gradient: {
//               type: "vertical",
//               shadeIntensity: 1,
//               inverseColors: !1,
//               opacityFrom: .30,
//               opacityTo: .05,
//               stops: [100, 100]
//           }
//         },
//         series: [{
//           name: 'Sales',
//           data: [28, 40, 36, 52, 38, 60, 38, 52, 36, 40]
//         }],
//         labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
//         yaxis: {
//           min: 0
//         },
//         grid: {
//           padding: {
//             top: 125,
//             right: 0,
//             bottom: 0,
//             left: 0
//           },
//         },
//         tooltip: {
//           x: {
//             show: false,
//           },
//           theme: Theme
//         },
//         colors: ['#00ab55']
//       }

//       /*
//           =================================
//               Revenue Monthly | Options
//           =================================
//       */
//     var options1 = {
//         chart: {
//           fontFamily: 'Nunito, sans-serif',
//           height: 365,
//           type: 'line',
//           zoom: {
//               enabled: false
//           },
//           dropShadow: {
//             enabled: true,
//             opacity: 0.2,
//             blur: 10,
//             left: -7,
//             top: 22
//           },
//           toolbar: {
//             show: false
//           },
//         },
//         colors: ['#e7515a', '#2196f3'],
//         dataLabels: {
//             enabled: false
//         },
//         markers: {
//           discrete: [{
//           seriesIndex: 0,
//           dataPointIndex: 7,
//           fillColor: '#000',
//           strokeColor: '#000',
//           size: 5
//         }, {
//           seriesIndex: 2,
//           dataPointIndex: 11,
//           fillColor: '#000',
//           strokeColor: '#000',
//           size: 4
//         }]
//         },
//         subtitle: {
//           text: '$10,840',
//           align: 'left',
//           margin: 0,
//           offsetX: 100,
//           offsetY: 20,
//           floating: false,
//           style: {
//             fontSize: '18px',
//             color:  '#00ab55'
//           }
//         },
//         title: {
//           text: 'Total Profit',
//           align: 'left',
//           margin: 0,
//           offsetX: -10,
//           offsetY: 20,
//           floating: false,
//           style: {
//             fontSize: '18px',
//             color:  '#bfc9d4'
//           },
//         },
//         stroke: {
//             show: true,
//             curve: 'smooth',
//             width: 2,
//             lineCap: 'square'
//         },
//         series: [],
//         noData: { text: "Cargando ..."},
//     //     series: [
//     //         {
//     //         name: 'Expenses',
//     //         data: [16800, 16800, 15500, 14800, 15500, 17000, 21000, 16000, 15000, 17000, 14000, 17000]
//     //     }, {
//     //         name: 'Income',
//     //         data: [16500, 17500, 16200, 17300, 16000, 21500, 16000, 17000, 16000, 19000, 18000, 19000]
//     //     }
//     // ],
//         // labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayu', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
//         // xaxis: {
//         //   axisBorder: {
//         //     show: false
//         //   },
//         //   axisTicks: {
//         //     show: false
//         //   },
//         //   crosshairs: {
//         //     show: true
//         //   },
//         //   labels: {
//         //     offsetX: 0,
//         //     offsetY: 5,
//         //     style: {
//         //         fontSize: '12px',
//         //         fontFamily: 'Nunito, sans-serif',
//         //         cssClass: 'apexcharts-xaxis-title',
//         //     },
//         //   }
//         // },
//         xaxis: {
//             categories: [],
//         },
//         // yaxis: {
//         //   labels: {
//         //     formatter: function(value, index) {
//         //       return (value / 1000) + 'K'
//         //     },
//         //     offsetX: -15,
//         //     offsetY: 0,
//         //     style: {
//         //         fontSize: '12px',
//         //         fontFamily: 'Nunito, sans-serif',
//         //         cssClass: 'apexcharts-yaxis-title',
//         //     },
//         //   }
//         // },
//         // grid: {
//         //   borderColor: '#191e3a',
//         //   strokeDashArray: 5,
//         //   xaxis: {
//         //       lines: {
//         //           show: true
//         //       }
//         //   },
//         //   yaxis: {
//         //       lines: {
//         //           show: false,
//         //       }
//         //   },
//         //   padding: {
//         //     top: -50,
//         //     right: 0,
//         //     bottom: 0,
//         //     left: 5
//         //   },
//         // },
//         grid: {
//             row: {
//                 colors: ['#e5e5e5','transparent'], // color de fondo separados por coma para alternarlos
//             }
//         },
//         legend: {
//           position: 'top',
//           horizontalAlign: 'right',
//           offsetY: -50,
//           fontSize: '16px',
//           fontFamily: 'Quicksand, sans-serif',
//           markers: {
//             width: 10,
//             height: 10,
//             strokeWidth: 0,
//             strokeColor: '#fff',
//             fillColors: undefined,
//             radius: 12,
//             onClick: undefined,
//             offsetX: -5,
//             offsetY: 0
//           },
//           itemMargin: {
//             horizontal: 10,
//             vertical: 20
//           }

//         },
//         tooltip: {
//           theme: Theme,
//           marker: {
//             show: true,
//           },
//           x: {
//             show: false,
//           }
//         },
//         fill: {
//             type:"gradient",
//             gradient: {
//                 type: "vertical",
//                 shadeIntensity: 1,
//                 inverseColors: !1,
//                 opacityFrom: .19,
//                 opacityTo: .05,
//                 stops: [100, 100]
//             }
//         },
//         responsive: [{
//           breakpoint: 575,
//           options: {
//             legend: {
//                 offsetY: -50,
//             },
//           },
//         }]
//       }

//       var options = {
//           chart: {
//               type: 'donut',
//               width: 370,
//               height: 430
//           },
//           colors: ['#622bd7', '#e2a03f', '#e7515a', '#e2a03f'],
//           dataLabels: {
//             enabled: false
//           },
//           legend: {
//               position: 'bottom',
//               horizontalAlign: 'center',
//               fontSize: '14px',
//               markers: {
//                 width: 10,
//                 height: 10,
//                 offsetX: -5,
//                 offsetY: 0
//               },
//               itemMargin: {
//                 horizontal: 10,
//                 vertical: 30
//               }
//           },
//           plotOptions: {
//             pie: {
//               donut: {
//                 size: '75%',
//                 background: 'transparent',
//                 labels: {
//                   show: true,
//                   name: {
//                     show: true,
//                     fontSize: '29px',
//                     fontFamily: 'Nunito, sans-serif',
//                     color: undefined,
//                     offsetY: -10
//                   },
//                   value: {
//                     show: true,
//                     fontSize: '26px',
//                     fontFamily: 'Nunito, sans-serif',
//                     color: '#bfc9d4',
//                     offsetY: 16,
//                     formatter: function (val) {
//                       return val
//                     }
//                   },
//                   total: {
//                     show: true,
//                     showAlways: true,
//                     label: 'Total',
//                     color: '#888ea8',
//                     formatter: function (w) {
//                       return w.globals.seriesTotals.reduce( function(a, b) {
//                         return a + b
//                       }, 0)
//                     }
//                   }
//                 }
//               }
//             }
//           },
//           stroke: {
//             show: true,
//             width: 15,
//             colors: '#0e1726'
//           },
//           series: [985, 737, 270],
//           labels: ['Apparel', 'Sports', 'Others'],

//           responsive: [
//             {
//               breakpoint: 1440, options: {
//                 chart: {
//                   width: 325
//                 },
//               }
//             },
//             {
//               breakpoint: 1199, options: {
//                 chart: {
//                   width: 380
//                 },
//               }
//             },
//             {
//               breakpoint: 575, options: {
//                 chart: {
//                   width: 320
//                 },
//               }
//             },
//           ],
//       }

//     } else {

//       var Theme = 'dark';

//       Apex.tooltip = {
//           theme: Theme
//       }

//       var d_2options1 = {
//         chart: {
//             height: 160,
//             type: 'bar',
//             stacked: true,
//             stackType: '100%',
//             toolbar: {
//                 show: false,
//             }
//         },
//         dataLabels: {
//             enabled: false,
//         },
//         stroke: {
//             show: true,
//             width: [3, 4],
//             curve: "smooth",
//         },
//         colors: ['#e2a03f', '#e0e6ed'],
//         series: [{
//             name: 'Sales',
//             data: [44, 55, 41, 67, 22, 43, 21]
//         },{
//             name: 'Last Week',
//             data: [13, 23, 20, 8, 13, 27, 33]
//         }],
//         xaxis: {
//             labels: {
//                 show: false,
//             },
//             categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'],
//             crosshairs: {
//             show: false
//             }
//         },
//         yaxis: {
//             show: false
//         },
//         fill: {
//             opacity: 1
//         },
//         plotOptions: {
//             bar: {
//                 horizontal: false,
//                 columnWidth: '25%',
//                 borderRadius: 8,
//             }
//         },
//         legend: {
//             show: false,
//         },
//         grid: {
//             show: false,
//             xaxis: {
//                 lines: {
//                     show: false
//                 }
//             },
//             padding: {
//             top: -20,
//             right: 0,
//             bottom: -40,
//             left: 0
//             },
//         },
//         responsive: [
//             {
//                 breakpoint: 575,
//                 options: {
//                     plotOptions: {
//                         bar: {
//                             borderRadius: 5,
//                             columnWidth: '35%'
//                         }
//                     },
//                 }
//             },
//         ],
//       }

//       var d_2options2 = {
//         chart: {
//           id: 'sparkline1',
//           group: 'sparklines',
//           type: 'area',
//           height: 290,
//           sparkline: {
//             enabled: true
//           },
//         },
//         stroke: {
//             curve: 'smooth',
//             width: 2
//         },
//         fill: {
//           opacity: 1,
//           // type:"gradient",
//           // gradient: {
//           //     type: "vertical",
//           //     shadeIntensity: 1,
//           //     inverseColors: !1,
//           //     opacityFrom: .30,
//           //     opacityTo: .05,
//           //     stops: [100, 100]
//           // }
//         },
//         series: [{
//           name: 'Sales',
//           data: [28, 40, 36, 52, 38, 60, 38, 52, 36, 40]
//         }],
//         labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
//         yaxis: {
//           min: 0
//         },
//         grid: {
//           padding: {
//             top: 125,
//             right: 0,
//             bottom: 0,
//             left: 0
//           },
//         },
//         tooltip: {
//           x: {
//             show: false,
//           },
//           theme: Theme
//         },
//         colors: ['#00ab55']
//       }

//       /*
//           =================================
//               Revenue Monthly | Options
//           =================================
//       */
//       var options1 = {
//         chart: {
//           fontFamily: 'Nunito, sans-serif',
//           height: 365,
//           type: 'line',
//           zoom: {
//               enabled: false
//           },
//           dropShadow: {
//             enabled: true,
//             opacity: 0.2,
//             blur: 10,
//             left: -7,
//             top: 22
//           },
//           toolbar: {
//             show: false
//           },
//         },
//         colors: ['#1b55e2', '#e7515a'],
//         dataLabels: {
//             enabled: false
//         },
//         markers: {
//           discrete: [{
//           seriesIndex: 0,
//           dataPointIndex: 7,
//           fillColor: '#000',
//           strokeColor: '#000',
//           size: 5
//         }, {
//           seriesIndex: 2,
//           dataPointIndex: 11,
//           fillColor: '#000',
//           strokeColor: '#000',
//           size: 4
//         }]
//         },
//         subtitle: {
//           text: '$10,840',
//           align: 'left',
//           margin: 0,
//           offsetX: 100,
//           offsetY: 20,
//           floating: false,
//           style: {
//             fontSize: '18px',
//             color:  '#4361ee'
//           }
//         },
//         title: {
//           text: 'Total Profit',
//           align: 'left',
//           margin: 0,
//           offsetX: -10,
//           offsetY: 20,
//           floating: false,
//           style: {
//             fontSize: '18px',
//             color:  '#0e1726'
//           },
//         },
//         stroke: {
//             show: true,
//             curve: 'smooth',
//             width: 2,
//             lineCap: 'square'
//         },
//         series:[],
//         noData: { text: "Cargando ..."},
//         // series: [{
//         //     name: 'Expenses',
//         //     data: [16800, 16800, 15500, 14800, 15500, 17000, 21000, 16000, 15000, 17000, 14000, 17000]
//         // }, {
//         //     name: 'Income',
//         //     data: [16500, 17500, 16200, 17300, 16000, 21500, 16000, 17000, 16000, 19000, 18000, 19000]
//         // }],
//         // labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
//         // xaxis: {
//         //   axisBorder: {
//         //     show: false
//         //   },
//         //   axisTicks: {
//         //     show: false
//         //   },
//         //   crosshairs: {
//         //     show: true
//         //   },
//         //   labels: {
//         //     offsetX: 0,
//         //     offsetY: 5,
//         //     style: {
//         //         fontSize: '12px',
//         //         fontFamily: 'Nunito, sans-serif',
//         //         cssClass: 'apexcharts-xaxis-title',
//         //     },
//         //   }
//         // },
//         // yaxis: {
//         //   labels: {
//         //     formatter: function(value, index) {
//         //       return (value / 1000) + 'K'
//         //     },
//         //     offsetX: -15,
//         //     offsetY: 0,
//         //     style: {
//         //         fontSize: '12px',
//         //         fontFamily: 'Nunito, sans-serif',
//         //         cssClass: 'apexcharts-yaxis-title',
//         //     },
//         //   }
//         // },
//         // grid: {
//         //   borderColor: '#e0e6ed',
//         //   strokeDashArray: 5,
//         //   xaxis: {
//         //       lines: {
//         //           show: true
//         //       }
//         //   },
//         //   yaxis: {
//         //       lines: {
//         //           show: false,
//         //       }
//         //   },
//         //   padding: {
//         //     top: -50,
//         //     right: 0,
//         //     bottom: 0,
//         //     left: 5
//         //   },
//         // },
//         xaxis: {
//             categories: [],
//         },
//         grid: {
//             row: {
//                 colors: ['#e5e5e5','transparent'], // color de fondo separados por coma para alternarlos
//             }
//         },
//         legend: {
//           position: 'top',
//           horizontalAlign: 'right',
//           offsetY: -50,
//           fontSize: '16px',
//           fontFamily: 'Quicksand, sans-serif',
//           markers: {
//             width: 10,
//             height: 10,
//             strokeWidth: 0,
//             strokeColor: '#fff',
//             fillColors: undefined,
//             radius: 12,
//             onClick: undefined,
//             offsetX: -5,
//             offsetY: 0
//           },
//           itemMargin: {
//             horizontal: 10,
//             vertical: 20
//           }

//         },
//         tooltip: {
//           theme: Theme,
//           marker: {
//             show: true,
//           },
//           x: {
//             show: false,
//           }
//         },
//         fill: {
//             type:"gradient",
//             gradient: {
//                 type: "vertical",
//                 shadeIntensity: 1,
//                 inverseColors: !1,
//                 opacityFrom: .19,
//                 opacityTo: .05,
//                 stops: [100, 100]
//             }
//         },
//         responsive: [{
//           breakpoint: 575,
//           options: {
//             legend: {
//                 offsetY: -50,
//             },
//           },
//         }]
//       }

//       /*
//           ==================================
//               Sales By Category | Options
//           ==================================
//       */
//       var options = {
//           chart: {
//               type: 'donut',
//               width: 370,
//               height: 430
//           },
//           colors: ['#622bd7', '#e2a03f', '#e7515a', '#e2a03f'],
//           dataLabels: {
//             enabled: false
//           },
//           legend: {
//               position: 'bottom',
//               horizontalAlign: 'center',
//               fontSize: '14px',
//               markers: {
//                 width: 10,
//                 height: 10,
//                 offsetX: -5,
//                 offsetY: 0
//               },
//               itemMargin: {
//                 horizontal: 10,
//                 vertical: 30
//               }
//           },
//           plotOptions: {
//             pie: {
//               donut: {
//                 size: '75%',
//                 background: 'transparent',
//                 labels: {
//                   show: true,
//                   name: {
//                     show: true,
//                     fontSize: '29px',
//                     fontFamily: 'Nunito, sans-serif',
//                     color: undefined,
//                     offsetY: -10
//                   },
//                   value: {
//                     show: true,
//                     fontSize: '26px',
//                     fontFamily: 'Nunito, sans-serif',
//                     color: '#0e1726',
//                     offsetY: 16,
//                     formatter: function (val) {
//                       return val
//                     }
//                   },
//                   total: {
//                     show: true,
//                     showAlways: true,
//                     label: 'Total',
//                     color: '#888ea8',
//                     formatter: function (w) {
//                       return w.globals.seriesTotals.reduce( function(a, b) {
//                         return a + b
//                       }, 0)
//                     }
//                   }
//                 }
//               }
//             }
//           },
//           stroke: {
//             show: true,
//             width: 15,
//             colors: '#fff'
//           },
//           series: [985, 737, 270],
//           labels: ['Apparel', 'Sports', 'Others'],

//           responsive: [
//             {
//               breakpoint: 1440, options: {
//                 chart: {
//                   width: 325
//                 },
//               }
//             },
//             {
//               breakpoint: 1199, options: {
//                 chart: {
//                   width: 380
//                 },
//               }
//             },
//             {
//               breakpoint: 575, options: {
//                 chart: {
//                   width: 320
//                 },
//               }
//             },
//           ],
//       }
//     }


//   /**
//       ==============================
//       |    @Render Charts Script    |
//       ==============================
//   */


//   /*
//       ============================
//           Daily Sales | Render
//       ============================
//   */


//   /*
//       ============================
//           Total Orders | Render
//       ============================
//   */
//   var d_2C_2 = new ApexCharts(document.querySelector("#total-orders"), d_2options2);
//   d_2C_2.render();

//   /*
//       ================================
//           Revenue Monthly | Render
//       ================================
//   */
//   chart1 = new ApexCharts(
//       document.querySelector("#revenueMonthly"),
//       options1
//   );

//   chart1.render();

//   /*
//       =================================
//           Sales By Category | Render
//       =================================
//   */
//   var chart = new ApexCharts(
//       document.querySelector("#chart-2"),
//       options
//   );

//   chart.render();

//   /*
//       =============================================
//           Perfect Scrollbar | Recent Activities
//       =============================================
//   */
//   const ps = new PerfectScrollbar(document.querySelector('.mt-container-ra'));

//   // const topSellingProduct = new PerfectScrollbar('.widget-table-three .table-scroll table', {
//   //   wheelSpeed:.5,
//   //   swipeEasing:!0,
//   //   minScrollbarLength:40,
//   //   maxScrollbarLength:100,
//   //   suppressScrollY: true

//   // });





//   /**
//      * =================================================================================================
//      * |     @Re_Render | Re render all the necessary JS when clicked to switch/toggle theme           |
//      * =================================================================================================
//      */

//   document.querySelector('.theme-toggle').addEventListener('click', function() {

//     // console.log(localStorage);

//     getcorkThemeObject = localStorage.getItem("theme");
//     getParseObject = JSON.parse(getcorkThemeObject)
//     ParsedObject = getParseObject;

//     if (ParsedObject.settings.layout.darkMode) {

//       /*
//       =================================
//           Revenue Monthly | Options
//       =================================
//     */

//       chart1.updateOptions({
//         colors: ['#e7515a', '#2196f3'],
//         subtitle: {
//           style: {
//             color:  '#00ab55'
//           }
//         },
//         title: {
//           style: {
//             color:  '#bfc9d4'
//           }
//         },
//         grid: {
//           borderColor: '#191e3a',
//         }
//       })


//       /*
//       ==================================
//           Sales By Category | Options
//       ==================================
//       */

//       chart.updateOptions({
//         stroke: {
//           colors: '#0e1726'
//         },
//         plotOptions: {
//           pie: {
//             donut: {
//               labels: {
//                 value: {
//                   color: '#bfc9d4'
//                 }
//               }
//             }
//           }
//         }
//       })


//       /*
//           =============================
//               Total Orders | Options
//           =============================
//       */

//       d_2C_2.updateOptions({
//         fill: {
//           type:"gradient",
//           gradient: {
//               type: "vertical",
//               shadeIntensity: 1,
//               inverseColors: !1,
//               opacityFrom: .30,
//               opacityTo: .05,
//               stops: [100, 100]
//           }
//         }
//       })

//     } else {

//       /*
//       =================================
//           Revenue Monthly | Options
//       =================================
//     */

//       chart1.updateOptions({
//         colors: ['#1b55e2', '#e7515a'],
//         subtitle: {
//           style: {
//             color:  '#4361ee'
//           }
//         },
//         title: {
//           style: {
//             color:  '#0e1726'
//           }
//         },
//         grid: {
//           borderColor: '#e0e6ed',
//         }
//       })


//       /*
//       ==================================
//           Sales By Category | Options
//       ==================================
//       */

//       chart.updateOptions({
//         stroke: {
//           colors: '#fff'
//         },
//         plotOptions: {
//           pie: {
//             donut: {
//               labels: {
//                 value: {
//                   color: '#0e1726'
//                 }
//               }
//             }
//           }
//         }
//       })

//       d_2C_2.updateOptions({
//         fill: {
//           type:"gradient",
//           opacity: 0.9,
//           gradient: {
//               type: "vertical",
//               shadeIntensity: 1,
//               inverseColors: !1,
//               opacityFrom: .45,
//               opacityTo: 0.1,
//               stops: [100, 100]
//           }
//         }
//       })
//     }
//   })
//   } catch(e) {
//       console.log(e);
//   }
// })


// var url = "http://projectone.test/chartsData"
// // $(document).ready(function(){
// //     $.getJSON(url, function(response) {
// //         console.log(response);
// //         chart1.updateSeries([{
// //             name: 'Lecturas',
// //             data: response.data
// //         }])
// //     })
// // });

$(document).ready(function(){
 var options = {
    chart: {
        fontFamily: 'Nunito, sans-serif',
        height: 365,
        type: 'area',
        zoom: {
            enabled: false
        },
        dropShadow: {
            enabled: true,
            opacity: 0.2,
            blur: 10,
            left: -7,
            top: 22
        },
        toolbar: {
            show: false
        },
    },
    colors: ['#1b55e2', '#e7515a'],
    dataLabels: {
        enabled: false
    },
    markers: {
            discrete: [{
            seriesIndex: 0,
            dataPointIndex: 7,
            fillColor: '#000',
            strokeColor: '#000',
            size: 5
        },{
            seriesIndex: 2,
            dataPointIndex: 11,
            fillColor: '#000',
            strokeColor: '#000',
            size: 4
        }]
    },
    subtitle: {
        text: 'Informacion del año',
        align: 'center',
        margin: 40,
        offsetY: 0,
        floating: false,
        style: {
            fontSize: '18px',
            color:  '#00ab55'
        }
    },
    title: {
        text: 'Grafica en Tiempo Real',
        align: 'center',
        margin: 0,
        floating: false,
        style: {
        fontSize: '18px',
            color:  '#bfc9d4'
        },
    },
    stroke: {
        show: true,
        curve: 'smooth',
        width: 2,
        lineCap: 'square'
    },
    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayu', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    xaxis: {
        categories: [],
        axisBorder: {
            show: false
        },
        axisTicks: {
            show: false
        },
        crosshairs: {
            show: true
        },
        labels: {
            offsetX: 0,
            offsetY: 5,
            style: {
                fontSize: '12px',
                fontFamily: 'Nunito, sans-serif',
                cssClass: 'apexcharts-xaxis-title',
            },
        }
    },
    yaxis: {
        labels: {
        formatter: function(value, index) {
            return (value / 1000) + 'K'
        },
        offsetX: -15,
        offsetY: 0,
        style: {
            fontSize: '12px',
            fontFamily: 'Nunito, sans-serif',
            cssClass: 'apexcharts-yaxis-title',
        },
        }
    },
    grid: {
        borderColor: '#191e3a',
        strokeDashArray: 5,
        xaxis: {
            lines: {
                show: true
            }
        },
        yaxis: {
            lines: {
                show: false,
            }
        },
        padding: {
        top: -50,
        right: 0,
        bottom: 0,
        left: 5
        },
    },
    series: [],
    noData: { text: "Cargando ..."},
    legend: {
        position: 'top',
        horizontalAlign: 'right',
        offsetY: -50,
        fontSize: '16px',
        fontFamily: 'Quicksand, sans-serif',
        markers: {
        width: 10,
        height: 10,
        strokeWidth: 0,
        strokeColor: '#fff',
        fillColors: undefined,
        radius: 12,
        onClick: undefined,
        offsetX: -5,
        offsetY: 0
        },
        itemMargin: {
        horizontal: 10,
        vertical: 20
        }

    },

    fill: {
        type:"gradient",
        gradient: {
            type: "vertical",
            shadeIntensity: 1,
            inverseColors: !1,
            opacityFrom: .19,
            opacityTo: .05,
            stops: [100, 100]
        }
    },

}
var chart = new ApexCharts( document.querySelector("#revenueMonthly") , options);
chart.render();

// var url = "http://192.168.1.100/chartsData/area"
var url = "http://projectone.test/chartsData/area"
$.getJSON(url, function(response) {
    // console.log(response.data);
    chart.updateSeries([{
            name: 'Actos',
            // data: response.data
            data: response.data

        }])
    });
});

// ================================================================================================
      var options = {
          chart: {
              type: 'donut',
              width: 370,
              height: 430
          },
          colors: ['#ffe43f', '#ffcf40', '#ff9b42', '#ff7140', "#ff2942", "#c5265e", "#4a3774", "#4b479b", "#0062ad", "#00717a", "#00975a", "#00cc5b"],
          dataLabels: {
            enabled: false
          },
          legend: {
              position: 'bottom',
              horizontalAlign: 'center',
              fontSize: '14px',
              markers: {
                width: 10,
                height: 10,
                offsetX: -5,
                offsetY: 0
              },
              itemMargin: {
                horizontal: 10,
                vertical: 30
              }
          },
          plotOptions: {
            pie: {
              donut: {
                // size: '75%',
                background: 'transparent',
                labels: {
                  show: true,
                  name: {
                    show: true,
                    fontSize: '29px',
                    fontFamily: 'Nunito, sans-serif',
                    // color: undefined,
                    offsetY: -10
                  },
                  value: {
                    show: true,
                    fontSize: '26px',
                    fontFamily: 'Nunito, sans-serif',
                    color: '#0e1726',
                    offsetY: 16,
                    formatter: function (val) {
                      return val
                    }
                  },
                  total: {
                    show: true,
                    showAlways: true,
                    label: 'Total',
                    color: '#888ea8',
                    formatter: function (w) {
                      return w.globals.seriesTotals.reduce( function(a, b) {
                        return a + b
                      }, 0)
                    }
                  }
                }
              }
            }
          },
        //   stroke: {
        //     show: true,
        //     width: 5,
        //     // colors: '#fff'
        //   },
        // series: [985, 737, 270, 123, 999, 9192, 11, 1929],
        series:[],
        noData: { text: "Cargando ..."},
        //   labels: ['Apparel', 'Sports', 'Others'],
        //   responsive: [
        //     {
        //       breakpoint: 1440, options: {
        //         chart: {
        //           width: 325
        //         },
        //       }
        //     },
        //     {
        //       breakpoint: 1199, options: {
        //         chart: {
        //           width: 380
        //         },
        //       }
        //     },
        //     {
        //       breakpoint: 575, options: {
        //         chart: {
        //           width: 320
        //         },
        //       }
        //     },
        //   ],
      }

var chart2 = new ApexCharts(
    document.querySelector("#chart-2"),
    options
);

chart2.render();

// const urldonut = "http://192.168.1.100/chartsData/dounut"
const urldonut = "http://projectone.test/chartsData/dounut"
$.getJSON(urldonut, function(response) {
    console.log(response.data);
    chart2.updateOptions({
        series: response.data.values,
        labels: response.data.labels
    })
    // chart2.updateSeries([1,2,3,4])
});

var d_2options1 = {
            chart: {
                height: 160,
                type: 'bar',
                stacked: true,
                stackType: '100%',
                toolbar: {
                    show: false,
                }
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                show: true,
                width: [3, 4],
                curve: "smooth",
            },
            colors: ['#e2a03f', '#e0e6ed'],
            series: [{
                name: 'Sales',
                data: [44, 55, 41, 67, 22, 43, 21]
            },{
                name: 'Last Week',
                data: [13, 23, 20, 8, 13, 27, 33]
            }],
            xaxis: {
                labels: {
                    show: false,
                },
                categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'],
                crosshairs: {
                show: false
                }
            },
            yaxis: {
                show: false
            },
            fill: {
                opacity: 1
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '25%',
                    borderRadius: 8,
                }
            },
            legend: {
                show: false,
            },
            grid: {
                show: false,
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                padding: {
                top: -20,
                right: 0,
                bottom: -40,
                left: 0
                },
            },
            responsive: [
                {
                    breakpoint: 575,
                    options: {
                        plotOptions: {
                            bar: {
                                borderRadius: 5,
                                columnWidth: '35%'
                            }
                        },
                    }
                },
            ],
          }
  var d_2C_1 = new ApexCharts(document.querySelector("#daily-sales"), d_2options1);
  d_2C_1.render();
  var d_2options2 = {
            chart: {
              id: 'sparkline1',
              group: 'sparklines',
              type: 'area',
              height: 290,
              sparkline: {
                enabled: true
              },
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
              opacity: 1,
              // type:"gradient",
              // gradient: {
              //     type: "vertical",
              //     shadeIntensity: 1,
              //     inverseColors: !1,
              //     opacityFrom: .30,
              //     opacityTo: .05,
              //     stops: [100, 100]
              // }
            },
            series: [{
              name: 'Sales',
              data: [28, 40, 36, 52, 38, 60, 38, 52, 36, 40]
            }],
            labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
            yaxis: {
              min: 0
            },
            grid: {
              padding: {
                top: 125,
                right: 0,
                bottom: 0,
                left: 0
              },
            },
            tooltip: {
              x: {
                show: false,
              },
            //   theme: Theme
            },
            colors: ['#00ab55']
          }

  var d_2C_2 = new ApexCharts(document.querySelector("#total-orders"), d_2options2);
  d_2C_2.render();
