import './bootstrap'

import ApexCharts from 'apexcharts'
import 'simplebar'
import 'jsvectormap'
import 'shufflejs'
import 'tobii'
import Alpine from 'alpinejs';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';


window.Alpine = Alpine;
Alpine.start();
// Optional: make Quill global for Alpine x-init
window.Quill = Quill; // ✅ important
window.ApexCharts = ApexCharts;

window.showToast = function (message, type = 'info') {
    window.dispatchEvent(new CustomEvent('toast', {
        detail: { message, type }
    }));
}

