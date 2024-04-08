import React from 'react';
import { createRoot } from 'react-dom/client';
import App from './app';

document.addEventListener('DOMContentLoaded', function() {
    var element = document.getElementById('mrs-dashboard-widget');
    if ( typeof element !== 'undefined' && element !== null ) {
        const root = createRoot(element);
        root.render(<App />);
    }
});