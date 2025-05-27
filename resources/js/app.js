import './bootstrap'

import ApexCharts from 'apexcharts'
import 'simplebar'
import 'jsvectormap'
import 'shufflejs'
import 'tobii'
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

window.ApexCharts = ApexCharts;

window.showToast = function (message, type = 'info') {
    window.dispatchEvent(new CustomEvent('toast', {
        detail: { message, type }
    }));
}

