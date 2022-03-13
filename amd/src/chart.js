// Standard license block omitted.
/*
 * @module     mod_digitala/mic
 * @copyright  2022 Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import chart from 'chart';

export const init = (pagenum) => {
    if (pagenum == 2) {
        const horLine = {
            afterDraw: (chart) => {
                const ctx = chart.ctx;
                ctx.lineWidth = 3.5;
                const scale = chart.chartArea.width / 4;
                const curr = chart.config._config.options.lineAt;
                const place = chart.chartArea.left + (scale * curr);

                ctx.beginPath();
                ctx.moveTo(place, chart.chartArea.top);
                ctx.lineTo(place, chart.chartArea.bottom);
                ctx.closePath();
                ctx.stroke();
            }
        };

        const kaavio = document.getElementById('kaavio').getContext('2d');
        new chart.Chart(kaavio, {
            type: 'bar',
            data: {
                labels: [""],
                datasets: [
                {
                    type: 'bar',
                    label: '0-1',
                    data: [1],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)'
                },
                {
                    type: 'bar',
                    label: '1-2',
                    data: [1],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)'
                },
                {
                    type: 'bar',
                    label: '2-3',
                    data: [1],
                    backgroundColor: 'rgba(255, 206, 86, 0.2)'
                },
                {
                    type: 'bar',
                    label: '3-4',
                    data: [1],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)'
                },
                ]
            },
            plugins: [horLine],
            options: {
                plugins: {
                    legend: {
                      display: false
                    }
                },
                lineAt: 2.3,
                indexAxis: 'y',
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    },
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        }
                    }]
                }
            }
        });
    }
};
