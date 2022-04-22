// Standard license block omitted.
/*
 * @module     mod_digitala/mic
 * @copyright  2022 Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

import chart from 'chart';
import {get_strings as getStrings} from 'core/str';


const createChart = async(id, grade, maxgrade) => {
    const horLine = {
        afterDraw: (chart) => {
            const ctx = chart.ctx;
            ctx.lineWidth = 3.5;
            const scale = chart.chartArea.width / maxgrade;
            const curr = chart.config._config.options.lineAt;
            const place = chart.chartArea.left + (scale * curr);

            ctx.strokeStyle = '#ffb000';
            ctx.beginPath();
            ctx.moveTo(place, chart.chartArea.top);
            ctx.lineTo(place, chart.chartArea.bottom);
            ctx.closePath();
            ctx.stroke();
        }
    };

    const kaavio = document.getElementById(id).getContext('2d');

    let strings = [];
    let basicDataset = [];
    for (let i = 0; i <= maxgrade; i++) {
        strings = [...strings, {
            key: `${id}_score-${i}`,
            component: 'digitala'
        }];
        if (i >= 1) {
            basicDataset = [...basicDataset, {
                type: 'bar',
                label: 'noshow',
                data: [1],
                backgroundColor: i % 2 ? 'rgba(182, 182, 182, 0.3)' : 'rgba(123, 123, 123, 0.3)'
            }];
        }
    }

    let lineSet = [];
    const evalStrings = await getStrings(strings);
    for (let i = 0; i < evalStrings.length; i++) {
        const evalString = evalStrings[i];
        const length = i === 0 ? 0 : 1;
        lineSet = [...lineSet,
            {
                type: 'line',
                label: evalString,
                data: [length],
                backgroundColor: 'rgba(0, 0, 0, 1)',
                showLine: true,
                pointRadius: 12.5,
            }
        ];
    }

    const selectedDataset = [
        ...lineSet,
        ...basicDataset,
    ];

    new chart.Chart(kaavio, {
        type: 'bar',
        data: {
            labels: [''],
            datasets: selectedDataset
        },
        plugins: [horLine],
        options: {
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: false,
                    external: (tooltipModel) => {
                        const name = tooltipModel.chart.canvas.attributes['data-eval-name'].value;
                        const tooltip = tooltipModel.tooltip;
                        const getBody = (bodyItem) => {
                            return bodyItem.lines;
                        };
                        let tooltipBox = document.getElementById(`grade-tooltip-${name}`);

                        if (!tooltipBox) {
                            tooltipBox = document.createElement('div');
                            tooltipBox.classList.add('tooltip-box');
                            tooltipBox.id = `grade-tooltip-${name}`;
                            document.body.appendChild(tooltipBox);
                        }

                        if (tooltip.body) {
                            const bodyLines = tooltip.body.map(getBody);
                            if (bodyLines[0][0].split(':')[0] === 'noshow') {
                                tooltipBox.style.opacity = 0;
                                return;
                            }
                        }

                        if (tooltip.opacity === 0) {
                            tooltipBox.style.opacity = 0;
                            return;
                        }

                        tooltipBox.classList.remove('above', 'below', 'no-transform');
                        if (tooltip.yAlign) {
                            tooltipBox.classList.add(tooltip.yAlign);
                        } else {
                            tooltipBox.classList.add('no-transform');
                        }

                        if (tooltip.body) {
                            const bodyLines = tooltip.body.map(getBody);

                            bodyLines.forEach((body) => {
                                tooltipBox.innerHTML = '<p class="tooltip-text">' + body[0].split(':')[0] + '</p>';
                            });

                        }
                        const position = tooltipModel.chart.canvas.getBoundingClientRect();

                        // Display, position, and set styles for font
                        tooltipBox.style.opacity = 1;
                        tooltipBox.style.position = 'absolute';
                        let left = tooltip.xAlign === 'right'
                            ? position.left + window.pageXOffset - 200 + tooltip.caretX
                            : position.left + window.pageXOffset + tooltip.caretX;
                        tooltipBox.style.left = left + 'px';
                        tooltipBox.style.top = position.top + window.pageYOffset + tooltip.caretY + 'px';

                        tooltipBox.style.pointerEvents = 'none';
                    }
                }
            },
            lineAt: grade,
            indexAxis: 'y',
            scales: {
                x: {
                    stacked: true,
                    ticks: {
                        font: {
                            size: 16
                        }
                    }
                },
                y: {
                    stacked: true
                }
            }
        }
    });
};

export const init = () => {
    const allCanvases = document.getElementsByClassName('report-chart');
    for (let i = 0; i < allCanvases.length; i++) {
        const canvas = allCanvases[i];
        createChart(canvas.attributes['data-eval-name'].value,
                    canvas.attributes['data-eval-grade'].value,
                    canvas.attributes['data-eval-maxgrade'].value);
    }
};
