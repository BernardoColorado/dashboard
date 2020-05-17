
    const  ctx = document.getElementById('myChart').getContext('2d');
    const  myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June'],
          datasets: [{
              label: 'Bar Chart',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: '#dc3545',
              borderColor: '#dc3545',
              borderWidth: 1
          }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              stepSize:5,
            },
            gridLines:{
              display:false
            }
          }],

          xAxes: [{
            ticks: {
              beginAtZero: true
            },
            gridLines:{
              display:false
            }
          }]
        }
      }
    });
    //
    const  ctx1 = document.getElementById('myChart1').getContext('2d');
    const  myChart1 = new Chart(ctx1, {
      type: 'line',
      data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June'],
          datasets: [{
              label: 'Line Chart',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: 'rgba(0,0,0,0)',
              borderColor: '#28a745',
              borderWidth: 2
          }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              stepSize:5,
            },
            gridLines:{
              display:false
            }
          }],

          xAxes: [{
            gridLines:{
              display:false
            }
          }]
        }
      }
    });

    const  ctx2 = document.getElementById('myChart2').getContext('2d');
    const  myChart2 = new Chart(ctx2, {
      type: 'line',
      data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June'],
          datasets: [{
              label: 'Area Chart',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: '#0f6db9',
              borderColor: '#0f6db9',
              borderWidth: 2,
              lineTension:0
          }]
      },
      options: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true,
              stepSize:5,
            },
            gridLines:{
              display:false
            }
          }],

          xAxes: [{
            gridLines:{
              display:false
            }
          }]
        }
      }
    });

    const  ctx3 = document.getElementById('myChart3').getContext('2d');
    var myChart3 = new Chart(ctx3, {
      type: 'scatter',
      data: {
        datasets: [{
          label: 'Scatter Dataset',
          borderColor:'#d6bc4a',
          backgroundColor:'#d6bc4a',
          data: [
            {x: 0,y: 10}, 
            {x: 1,y: 9.5}, 
            {x: 2,y: 8.2},
            {x: 3,y: 7},
            {x: 4,y: 5.9},
            {x: 5,y: 5.1},
            {x: 6,y: 4.3}, 
          ]
        }]
      },
      options: {
          scales: {
              xAxes: [{
                  type: 'linear',
                  position: 'bottom',
                  gridLines:{
                    display:false
                  }
              }],
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  stepSize:5,
                },
                type: 'linear',
                position: 'bottom',
                gridLines:{
                  display:false
                }
            }]
          }
      }
  });