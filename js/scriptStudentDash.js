var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
  type: 'radar',
  data: {
    labels: [
      'Motivation',
      'Personality',
      'Leadership Preferences',
      'Writing Skills',
      'Software Skills',
      'Organisation and Planning Skills',
      'Numeracy Skills',
      'Research Skills',
      'Knowledge Skills',
      'Creativity'
    ],
    datasets: [
      {
        label: 'Dimension Analysis',
        data: [10, 9, 3, 4, 5, 6, 7, 8, 9, 10], //scores
        backgroundColor: 'rgba(48, 164, 255, 0.4)',
        borderColor: 'rgba(48, 164, 255, 1)',
        borderWidth: 2,
        pointBackgroundColor: '',
        pointBorderColor: 'transparent',
        pointBorderWidth: 1,
        pointRadius: 2,
        pointHoverRadius: 6
      }
    ]
  },
  options: {
    animation: {
      duration: 2000
    },
    scales: {
      r: {
        angleLines: {
          display: true
        },
        suggestedMin: 0,
        suggestedMax: 10
      }
    }
  }
});
