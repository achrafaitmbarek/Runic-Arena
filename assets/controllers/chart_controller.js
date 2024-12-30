import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
  connect() {
    this.element.addEventListener("chartjs:pre-connect", this._onPreConnect);
    this.element.addEventListener("chartjs:connect", this._onConnect);
  }

  disconnect() {
    this.element.removeEventListener("chartjs:pre-connect", this._onPreConnect);
    this.element.removeEventListener("chartjs:connect", this._onConnect);
  }

  _onPreConnect(event) {
    // Customize chart configuration before initialization
    event.detail.config.options = {
      ...event.detail.config.options,
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: "bottom",
          labels: {
            padding: 20,
            font: {
              size: 14,
            },
          },
        },
      },
    };
  }

  _onConnect(event) {
    // Access the chart instance after initialization
    const chart = event.detail.chart;
    chart.canvas.style.height = "300px";
  }
}
