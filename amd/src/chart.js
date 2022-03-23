// Standard license block omitted.
/*
 * @module     mod_digitala/mic
 * @copyright  2022 Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import chart from 'chart';
import {get_strings} from 'core/str';


const createChart = async (id, grade, maxgrade) => {
    const horLine = {
        afterDraw: (chart) => {
            const ctx = chart.ctx;
            ctx.lineWidth = 3.5;
            const scale = chart.chartArea.width / maxgrade;
            const curr = chart.config._config.options.lineAt;
            const place = chart.chartArea.left + (scale * curr);

            ctx.strokeStyle = "#ffb000";
            ctx.beginPath();
            ctx.moveTo(place, chart.chartArea.top);
            ctx.lineTo(place, chart.chartArea.bottom);
            ctx.closePath();
            ctx.stroke();
        }
    };

    const kaavio = document.getElementById(id).getContext('2d');

    let strings = [];
    for (let i = 0; i <= maxgrade; i++) {
        strings = [...strings, {
            key: `${id}_score-${i}`,
            component: 'digitala'
        }];
    }

    let lineSet = [];

    const evalStrings = await get_strings(strings);
    for (let i = 0; i < evalStrings.length; i++) {
        const evalString = evalStrings[i];
        window.console.log(evalString);
        const length = i === 0 ? 0 : 1;
        lineSet = [...lineSet,
            {
                type: 'line',
                label: evalString,
                data: [length],
                backgroundColor: 'rgba(255,0,0,1)',
                showLine: true,
                pointRadius: 5,
            }
        ];
    }

    let basicDataset = [
        ...lineSet,
        {
            type: 'bar',
            label: 'noshow',
            data: [1],
            backgroundColor: 'rgba(182, 182, 182, 0.3)'
        },
        {
            type: 'bar',
            label: 'noshow',
            data: [1],
            backgroundColor: 'rgba(123, 123, 123, 0.3)'
        },
        {
            type: 'bar',
            label: 'noshow',
            data: [1],
            backgroundColor: 'rgba(182, 182, 182, 0.3)'
        },
    ];

    window.console.log('maxGrade', maxgrade);
    if (maxgrade === '4') {
        basicDataset = [...basicDataset, {
            type: 'bar',
            label: 'noshow',
            data: [1],
            backgroundColor: 'rgba(123, 123, 123, 0.3)'
        }];
    }

    const selectedDataset = basicDataset;

    new chart.Chart(kaavio, {
        type: 'bar',
        data: {
            labels: [""],
            datasets: selectedDataset
        },
        plugins: [horLine],
        options: {
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    filter: (tooltipItem) => {
                        window.console.log('label', tooltipItem);
                        return tooltipItem.dataset.type !== "bar";
                    },
                    external: (tooltipModel) => {
                        window.console.log(tooltipModel.chart.canvas.attributes['data-eval-name'].value);
                        window.console.log(tooltipModel);
                    }
                }
            },
            lineAt: grade,
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
};

export const init = (pagenum) => {

    if (pagenum === 2) {
        const allCanvases = document.getElementsByClassName('report-chart');
        window.console.log('allCanvases >', allCanvases);
        for (let i = 0; i < allCanvases.length; i++) {
            const canvas = allCanvases[i];
            window.console.log('Attributes:', canvas.attributes);
            createChart(canvas.attributes["data-eval-name"].value,
                        canvas.attributes["data-eval-grade"].value,
                        canvas.attributes["data-eval-maxgrade"].value);
        }
        // createChart(id, value);
    }
};