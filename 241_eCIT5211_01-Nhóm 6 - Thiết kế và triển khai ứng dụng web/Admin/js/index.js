new Chart(document.getElementById("chartjs-bar"), {
    type: "bar",
    data: {
      labels: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      datasets: [
        {
          label: "Last year",
          backgroundColor: "#1b68ff",
          borderColor: "#b4cdff",

          data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
          barPercentage: 0.75,
          categoryPercentage: 0.5,
        },
        {
          label: "This year",
          backgroundColor: "#dee2e6",
          borderColor: "#dee2e6",
          hoverBackgroundColor: "#dee2e6",
          hoverBorderColor: "#dee2e6",
          data: [69, 66, 24, 48, 52, 51, 44, 53, 62, 79, 51, 68],
          barPercentage: 0.75,
          categoryPercentage: 0.5,
        },
      ],
    },
    options: {
      scales: {
        yAxes: [
          {
            gridLines: {
              display: false,
            },
            stacked: false,
          },
        ],
        xAxes: [
          {
            stacked: false,
            gridLines: {
              color: "transparent",
            },
          },
        ],
      },
    },
  });
