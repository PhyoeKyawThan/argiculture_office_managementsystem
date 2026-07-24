import { createIcons, icons } from 'lucide';
import SignaturePad from 'signature_pad';

window.lucide = { createIcons, icons };
window.SignaturePad = SignaturePad;

function initLucideIcons() {
    createIcons({ icons });
}

function dataURLToBlob(dataURL) {
    const parts = dataURL.split(',');
    const mime = parts[0].match(/:(.*?);/)[1];
    const bstr = atob(parts[1]);
    const n = bstr.length;
    const u8arr = new Uint8Array(n);
    for (let i = 0; i < n; i++) {
        u8arr[i] = bstr.charCodeAt(i);
    }
    return new Blob([u8arr], { type: mime });
}

async function processSignature(pad, fileInput) {
    if (!pad.isEmpty()) {
        const dataUrl = pad.toDataURL('image/png');
        const blob = dataURLToBlob(dataUrl);
        const file = new File([blob], 'signature.png', { type: 'image/png' });
        const dt = new DataTransfer();
        dt.items.add(file);
        fileInput.files = dt.files;
    }
}

function initSignaturePads() {
    const mainPadEl = document.getElementById('signature-pad');
    if (!mainPadEl) return;

    const mainCanvas = mainPadEl;
    mainCanvas.width = mainCanvas.clientWidth;
    mainCanvas.height = mainCanvas.clientHeight;
    
    const mainSigPad = new SignaturePad(mainCanvas, { 
        backgroundColor: 'rgba(255, 255, 255, 0)' 
    });
    
    const clearMainBtn = document.getElementById('clear-main-sig');
    if (clearMainBtn) {
        clearMainBtn.addEventListener('click', () => {
            mainSigPad.clear();
        });
    }

    document.querySelectorAll('.sig-pad-canvas').forEach(canvas => {
        canvas.width = canvas.clientWidth;
        canvas.height = canvas.clientHeight;
        
        const pad = new SignaturePad(canvas, { 
            backgroundColor: 'rgba(255, 255, 255, 0)' 
        });
        
        canvas._sigPad = pad;
        const hiddenInput = canvas.nextElementSibling;
        const clearBtn = hiddenInput.nextElementSibling;
        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                pad.clear();
                const dt = new DataTransfer();
                hiddenInput.files = dt.files;
            });
        }
    });

    const form = document.getElementById('license-form');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const promises = [];
            
            if (!mainSigPad.isEmpty()) {
                promises.push(processSignature(mainSigPad, document.getElementById('signature-file')));
            }
            
            document.querySelectorAll('.sig-pad-canvas').forEach(canvas => {
                const pad = canvas._sigPad;
                const hiddenInput = canvas.nextElementSibling;
                if (pad && !pad.isEmpty()) {
                    promises.push(processSignature(pad, hiddenInput));
                }
            });
            
            await Promise.all(promises);
            form.submit();
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initLucideIcons();
        initSignaturePads();
    });
} else {
    initLucideIcons();
    initSignaturePads();
}