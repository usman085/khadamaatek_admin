/* eslint-disable object-shorthand */
/* global Chart, coreui, coreui.Utils.getStyle, coreui.Utils.hexToRgba */

/**
 * --------------------------------------------------------------------------
 * CoreUI Boostrap Admin Template (v3.0.0): main.js
 * Licensed under MIT (https://coreui.io/license)
 * --------------------------------------------------------------------------
 */

/* eslint-disable no-magic-numbers */
// Disable the on-canvas tooltip
Chart.defaults.global.pointHitDetectionRadius = 1;
Chart.defaults.global.tooltips.enabled = false;
Chart.defaults.global.tooltips.mode = "index";
Chart.defaults.global.tooltips.position = "nearest";
Chart.defaults.global.tooltips.custom = coreui.ChartJS.customTooltips;
Chart.defaults.global.defaultFontColor = "#646470";
Chart.defaults.global.responsiveAnimationDuration = 1;

// eslint-disable-next-line no-unused-vars
const cardChart1 = new Chart(document.getElementById("card-chart1"), {
    type: "line",
    data: {
        labels: [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July"
        ],
        datasets: [
            {
                label: "My First dataset",
                display: false,
                backgroundColor: "rgba(255,255,255,.2)",
                borderColor: "rgba(255,255,255,.55)",
                data: [78, 81, 80, 45, 34, 12, 40]
            }
        ]
    },
    options: {
        maintainAspectRatio: false,
        legend: {
            display: false
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem) {
                    return tooltipItem.yLabel;
                }
            }
        },
        scales: {
            xAxes: [
                {
                    display: false
                }
            ],
            yAxes: [
                {
                    display: false
                }
            ]
        },
        elements: {
            line: {
                borderWidth: 2
            },
            point: {
                radius: 0,
                hitRadius: 10,
                hoverRadius: 4
            }
        }
    }
});
const cardChart2 = new Chart(document.getElementById("card-chart2"), {
    type: "line",
    data: {
        labels: [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July"
        ],
        datasets: [
            {
                label: "My First dataset",
                display: false,
                backgroundColor: "rgba(255,255,255,.2)",
                borderColor: "rgba(255,255,255,.55)",
                data: [78, 81, 80, 45, 34, 12, 40]
            }
        ]
    },
    options: {
        maintainAspectRatio: false,
        legend: {
            display: false
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem) {
                    return tooltipItem.yLabel;
                }
            }
        },
        scales: {
            xAxes: [
                {
                    display: false
                }
            ],
            yAxes: [
                {
                    display: false
                }
            ]
        },
        elements: {
            line: {
                borderWidth: 2
            },
            point: {
                radius: 0,
                hitRadius: 10,
                hoverRadius: 4
            }
        }
    }
});
const cardChart3 = new Chart(document.getElementById("card-chart3"), {
    type: "line",
    data: {
        labels: [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July"
        ],
        datasets: [
            {
                label: "My First dataset",
                display: false,
                backgroundColor: "rgba(255,255,255,.2)",
                borderColor: "rgba(255,255,255,.55)",
                data: [78, 81, 80, 45, 34, 12, 40]
            }
        ]
    },
    options: {
        maintainAspectRatio: false,
        legend: {
            display: false
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem) {
                    return tooltipItem.yLabel;
                }
            }
        },
        scales: {
            xAxes: [
                {
                    display: false
                }
            ],
            yAxes: [
                {
                    display: false
                }
            ]
        },
        elements: {
            line: {
                borderWidth: 2
            },
            point: {
                radius: 0,
                hitRadius: 10,
                hoverRadius: 4
            }
        }
    }
});
const cardChart4 = new Chart(document.getElementById("card-chart4"), {
    type: "line",
    data: {
        labels: [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July"
        ],
        datasets: [
            {
                label: "My First dataset",
                display: false,
                backgroundColor: "rgba(255,255,255,.2)",
                borderColor: "rgba(255,255,255,.55)",
                data: [78, 81, 80, 45, 34, 12, 40]
            }
        ]
    },
    options: {
        maintainAspectRatio: false,
        legend: {
            display: false
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem) {
                    return tooltipItem.yLabel;
                }
            }
        },
        scales: {
            xAxes: [
                {
                    display: false
                }
            ],
            yAxes: [
                {
                    display: false
                }
            ]
        },
        elements: {
            line: {
                borderWidth: 2
            },
            point: {
                radius: 0,
                hitRadius: 10,
                hoverRadius: 4
            }
        }
    }
});
const cardChart5 = new Chart(document.getElementById("card-chart5"), {
    type: "line",
    data: {
        labels: [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July"
        ],
        datasets: [
            {
                label: "My First dataset",
                display: false,
                backgroundColor: "rgba(255,255,255,.2)",
                borderColor: "rgba(255,255,255,.55)",
                data: [78, 81, 80, 45, 34, 12, 40]
            }
        ]
    },
    options: {
        maintainAspectRatio: false,
        legend: {
            display: false
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem) {
                    return tooltipItem.yLabel;
                }
            }
        },
        scales: {
            xAxes: [
                {
                    display: false
                }
            ],
            yAxes: [
                {
                    display: false
                }
            ]
        },
        elements: {
            line: {
                borderWidth: 2
            },
            point: {
                radius: 0,
                hitRadius: 10,
                hoverRadius: 4
            }
        }
    }
});
const cardChart6 = new Chart(document.getElementById("card-chart6"), {
    type: "line",
    data: {
        labels: [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July"
        ],
        datasets: [
            {
                label: "My First dataset",
                display: false,
                backgroundColor: "rgba(255,255,255,.2)",
                borderColor: "rgba(255,255,255,.55)",
                data: [78, 81, 80, 45, 34, 12, 40]
            }
        ]
    },
    options: {
        maintainAspectRatio: false,
        legend: {
            display: false
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem) {
                    return tooltipItem.yLabel;
                }
            }
        },
        scales: {
            xAxes: [
                {
                    display: false
                }
            ],
            yAxes: [
                {
                    display: false
                }
            ]
        },
        elements: {
            line: {
                borderWidth: 2
            },
            point: {
                radius: 0,
                hitRadius: 10,
                hoverRadius: 4
            }
        }
    }
});
