
    const  ctx = document.getElementById('myChart').getContext('2d');
    const  myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June','July'],
          datasets: [{
              label: '2019 Sales',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: '#5072b2',
              borderColor: '#5072b2',
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