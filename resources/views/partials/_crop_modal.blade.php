{{--
    ╔═══════════════════════════════════════════════════════════╗
    ║    PARTIAL: CROP MODAL — Foto 3x4 & KK                   ║
    ║    Include di setiap form yang punya upload foto santri   ║
    ║    Depends on: Cropper.js (via CDN, di-push lewat sini)  ║
    ╚═══════════════════════════════════════════════════════════╝

    CARA PAKAI:
    1. @include('partials._crop_modal')
    2. Pastikan input foto punya id="inputFoto" / id="inputKK"  (wali)
       atau id="foto_3x4" / id="foto_kk" (admin)
       — bisa dikonfigurasi via JS setelah include
--}}

@once
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<style>
    /* ──────── OVERLAY MODAL CROP ──────── */
    .crop-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: rgba(15, 23, 42, 0.82);
        backdrop-filter: blur(6px);
        align-items: center;
        justify-content: center;
    }
    .crop-modal-overlay.show { display: flex; }

    /* ──────── BOX ──────── */
    .crop-modal-box {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 24px 64px rgba(0,0,0,.35);
        width: 92vw;
        max-width: 780px;
        max-height: 92vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        animation: cropPopIn .2s cubic-bezier(.34,1.56,.64,1);
    }
    @keyframes cropPopIn {
        from { opacity:0; transform:scale(.92); }
        to   { opacity:1; transform:scale(1); }
    }

    /* ──────── HEADER ──────── */
    .crop-modal-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 22px;
        border-bottom: 1.5px solid #e2e8f0;
        background: #f8fafc;
        flex-shrink: 0;
    }
    .crop-modal-header-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.05rem; flex-shrink: 0;
    }
    .crop-modal-header-icon.portrait  { background:#dbeafe; color:#1d4ed8; }
    .crop-modal-header-icon.landscape { background:#d1fae5; color:#065f46; }
    .crop-modal-header h5 {
        font-size: .95rem; font-weight: 700; color: #1e293b; margin: 0;
    }
    .crop-modal-header p {
        font-size: .75rem; color: #64748b; margin: 2px 0 0;
    }
    .crop-modal-close {
        margin-left: auto;
        width: 32px; height: 32px;
        border-radius: 8px;
        background: #f1f5f9;
        border: none; cursor: pointer;
        color: #64748b; font-size: .9rem;
        display: flex; align-items: center; justify-content: center;
        transition: background .15s;
    }
    .crop-modal-close:hover { background: #fee2e2; color: #ef4444; }

    /* ──────── BODY ──────── */
    .crop-modal-body {
        flex: 1;
        overflow: auto;
        padding: 18px 22px;
        min-height: 0;
    }
    .crop-canvas-wrap {
        width: 100%;
        max-height: 52vh;
        overflow: hidden;
        background: #0f172a;
        border-radius: 12px;
        position: relative;
    }
    .crop-canvas-wrap img {
        display: block;
        max-width: 100%;
    }

    /* ──────── GUIDE BADGE ──────── */
    .crop-guide-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f0fdf4;
        border: 1.5px solid #a7f3d0;
        color: #065f46;
        border-radius: 20px;
        font-size: .75rem;
        font-weight: 600;
        padding: 5px 14px;
        margin-top: 12px;
    }
    .crop-guide-badge.portrait-badge  { background:#eff6ff; border-color:#bfdbfe; color:#1e40af; }
    .crop-guide-badge.landscape-badge { background:#f0fdf4; border-color:#a7f3d0; color:#065f46; }

    /* ──────── TOOLBAR ──────── */
    .crop-toolbar {
        display: flex;
        gap: 8px;
        margin-top: 14px;
        flex-wrap: wrap;
    }
    .crop-tool-btn {
        width: 36px; height: 36px;
        border-radius: 8px;
        background: #f1f5f9;
        border: 1.5px solid #e2e8f0;
        color: #475569;
        font-size: .85rem;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: all .15s;
    }
    .crop-tool-btn:hover { background: #e2e8f0; color: #1e293b; }

    /* ──────── FOOTER ──────── */
    .crop-modal-footer {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        padding: 14px 22px;
        border-top: 1.5px solid #e2e8f0;
        background: #f8fafc;
        flex-shrink: 0;
    }
    .crop-btn-cancel {
        display: inline-flex; align-items: center; gap: 7px;
        background: transparent;
        border: 1.5px solid #e2e8f0;
        color: #64748b;
        padding: 9px 20px; border-radius: 10px;
        font-size: .875rem; font-weight: 600;
        cursor: pointer;
        transition: all .15s;
    }
    .crop-btn-cancel:hover { border-color: #94a3b8; color: #374151; }

    .crop-btn-apply {
        display: inline-flex; align-items: center; gap: 7px;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff; border: none;
        padding: 9px 24px; border-radius: 10px;
        font-size: .875rem; font-weight: 700;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(16,185,129,.3);
        transition: all .15s;
    }
    .crop-btn-apply:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(16,185,129,.4); }
</style>
@endpush

{{-- ═══════════════════════ HTML MODAL ═══════════════════════ --}}
<div class="crop-modal-overlay" id="cropModalOverlay" role="dialog" aria-modal="true" aria-label="Penyesuaian Foto">
    <div class="crop-modal-box">

        {{-- Header --}}
        <div class="crop-modal-header">
            <div class="crop-modal-header-icon portrait" id="cropHeaderIcon">
                <i class="fas fa-portrait"></i>
            </div>
            <div>
                <h5 id="cropModalTitle">Sesuaikan Foto 3×4</h5>
                <p id="cropModalDesc">Atur posisi & ukuran foto agar sesuai rasio 3×4 sebelum disimpan</p>
            </div>
            <button class="crop-modal-close" id="cropModalCloseX" type="button" title="Tutup">
                <i class="fas fa-xmark"></i>
            </button>
        </div>

        {{-- Body --}}
        <div class="crop-modal-body">
            <div class="crop-canvas-wrap">
                <img id="cropImage" src="" alt="Crop Preview">
            </div>

            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
                <span class="crop-guide-badge portrait-badge" id="cropGuideBadge">
                    <i class="fas fa-crop-simple"></i>
                    <span id="cropGuideText">Rasio terkunci: 3 × 4 (Portrait)</span>
                </span>
                <div class="crop-toolbar">
                    <button type="button" class="crop-tool-btn" id="cropRotateL" title="Putar Kiri"><i class="fas fa-rotate-left"></i></button>
                    <button type="button" class="crop-tool-btn" id="cropRotateR" title="Putar Kanan"><i class="fas fa-rotate-right"></i></button>
                    <button type="button" class="crop-tool-btn" id="cropFlipH"  title="Cermin Horizontal"><i class="fas fa-left-right"></i></button>
                    <button type="button" class="crop-tool-btn" id="cropFlipV"  title="Cermin Vertikal"><i class="fas fa-up-down"></i></button>
                    <button type="button" class="crop-tool-btn" id="cropZoomIn" title="Perbesar"><i class="fas fa-magnifying-glass-plus"></i></button>
                    <button type="button" class="crop-tool-btn" id="cropZoomOut" title="Perkecil"><i class="fas fa-magnifying-glass-minus"></i></button>
                    <button type="button" class="crop-tool-btn" id="cropReset" title="Reset"><i class="fas fa-arrows-rotate"></i></button>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="crop-modal-footer">
            <button type="button" class="crop-btn-cancel" id="cropBtnCancel">
                <i class="fas fa-xmark"></i> Batal
            </button>
            <button type="button" class="crop-btn-apply" id="cropBtnApply">
                <i class="fas fa-scissors"></i> Crop &amp; Gunakan Foto Ini
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
(function () {
    'use strict';

    /* ─── State ─── */
    let cropperInstance = null;
    let currentInputEl  = null;   // <input type="file"> yang memicu crop
    let currentPreviewSelector = null; // selector preview img/div
    let currentMode     = 'foto'; // 'foto' | 'kk'

    const RATIO_FOTO = 3 / 4;     // portrait 3:4
    const RATIO_KK   = 16 / 9;    // landscape KK

    /* ─── Elemen ─── */
    const overlay     = document.getElementById('cropModalOverlay');
    const cropImg     = document.getElementById('cropImage');
    const modalTitle  = document.getElementById('cropModalTitle');
    const modalDesc   = document.getElementById('cropModalDesc');
    const headerIcon  = document.getElementById('cropHeaderIcon');
    const guideBadge  = document.getElementById('cropGuideBadge');
    const guideText   = document.getElementById('cropGuideText');

    /* ─── Fungsi buka modal ─── */
    function openCropModal(file, inputEl, previewSelector, mode) {
        if (!file || !file.type.startsWith('image/')) return;

        currentInputEl         = inputEl;
        currentPreviewSelector = previewSelector;
        currentMode            = mode || 'foto';

        const isKK = currentMode === 'kk';

        /* Update teks & ikon header */
        if (isKK) {
            modalTitle.textContent = 'Sesuaikan Foto Kartu Keluarga';
            modalDesc.textContent  = 'Atur posisi foto KK (orientasi landscape) sebelum disimpan';
            headerIcon.className   = 'crop-modal-header-icon landscape';
            headerIcon.innerHTML   = '<i class="fas fa-id-card"></i>';
            guideBadge.className   = 'crop-guide-badge landscape-badge';
            guideText.textContent  = 'Rasio terkunci: 16 × 9 (Landscape KK)';
        } else {
            modalTitle.textContent = 'Sesuaikan Foto 3×4 Santri';
            modalDesc.textContent  = 'Atur posisi & ukuran foto agar sesuai rasio 3×4 sebelum disimpan';
            headerIcon.className   = 'crop-modal-header-icon portrait';
            headerIcon.innerHTML   = '<i class="fas fa-portrait"></i>';
            guideBadge.className   = 'crop-guide-badge portrait-badge';
            guideText.textContent  = 'Rasio terkunci: 3 × 4 (Portrait)';
        }

        /* Baca file & tampilkan di modal */
        const reader = new FileReader();
        reader.onload = function (e) {
            cropImg.src = e.target.result;
            overlay.classList.add('show');

            /* Destroy cropper lama */
            if (cropperInstance) { cropperInstance.destroy(); cropperInstance = null; }

            /* Init cropper baru */
            cropperInstance = new Cropper(cropImg, {
                aspectRatio     : isKK ? RATIO_KK : RATIO_FOTO,
                viewMode        : 1,
                dragMode        : 'move',
                autoCropArea    : 0.85,
                restore         : false,
                guides          : true,
                center          : true,
                highlight       : true,
                cropBoxMovable  : true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
                responsive      : true,
            });
        };
        reader.readAsDataURL(file);
    }

    /* ─── Tutup modal ─── */
    function closeCropModal(resetInput) {
        overlay.classList.remove('show');
        if (cropperInstance) { cropperInstance.destroy(); cropperInstance = null; }
        if (resetInput && currentInputEl) currentInputEl.value = '';
        currentInputEl = null;
    }

    document.getElementById('cropModalCloseX').addEventListener('click', () => closeCropModal(true));
    document.getElementById('cropBtnCancel').addEventListener('click',    () => closeCropModal(true));
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) closeCropModal(true);
    });

    /* ─── Toolbar ─── */
    document.getElementById('cropRotateL').addEventListener('click',  () => cropperInstance?.rotate(-90));
    document.getElementById('cropRotateR').addEventListener('click',  () => cropperInstance?.rotate(90));
    document.getElementById('cropFlipH').addEventListener('click',    () => cropperInstance?.scaleX(cropperInstance.getData().scaleX === -1 ? 1 : -1));
    document.getElementById('cropFlipV').addEventListener('click',    () => cropperInstance?.scaleY(cropperInstance.getData().scaleY === -1 ? 1 : -1));
    document.getElementById('cropZoomIn').addEventListener('click',   () => cropperInstance?.zoom(0.1));
    document.getElementById('cropZoomOut').addEventListener('click',  () => cropperInstance?.zoom(-0.1));
    document.getElementById('cropReset').addEventListener('click',    () => cropperInstance?.reset());

    /* ─── Tombol Crop & Gunakan ─── */
    document.getElementById('cropBtnApply').addEventListener('click', function () {
        if (!cropperInstance || !currentInputEl) return;

        const btn = this;
        btn.disabled  = true;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Memproses...';

        /* Ukuran output hasil crop */
        const isKK   = currentMode === 'kk';
        const outW   = isKK ? 1600 : 900;
        const outH   = isKK ? 900  : 1200;

        const canvas = cropperInstance.getCroppedCanvas({
            width      : outW,
            height     : outH,
            imageSmoothingEnabled  : true,
            imageSmoothingQuality  : 'high',
        });

        canvas.toBlob(function (blob) {
            /* Ganti file di input dengan hasil crop */
            const origName = currentInputEl.files[0]?.name || 'foto_crop.jpg';
            const ext      = origName.split('.').pop().toLowerCase();
            const mimeType = ext === 'png' ? 'image/png' : 'image/jpeg';
            const fileName = origName.replace(/\.[^.]+$/, '') + '_crop.' + (ext === 'png' ? 'png' : 'jpg');

            const croppedFile = new File([blob], fileName, { type: mimeType, lastModified: Date.now() });

            /* Inject ke input file via DataTransfer */
            const dt = new DataTransfer();
            dt.items.add(croppedFile);
            currentInputEl.files = dt.files;

            /* Update semua preview img yang ada */
            const previewUrl = URL.createObjectURL(blob);

            if (currentPreviewSelector) {
                /* Coba update <img id="..."> */
                const imgEl = document.querySelector(currentPreviewSelector);
                if (imgEl) {
                    if (imgEl.tagName === 'IMG') {
                        imgEl.src = previewUrl;
                        imgEl.style.display = 'block';
                    } else {
                        /* Div preview (seperti di admin) */
                        imgEl.innerHTML = '<img src="' + previewUrl + '" style="max-height:200px;max-width:100%;border-radius:6px;object-fit:cover;">';
                    }
                }
            }

            /* Juga update label custom-file jika ada */
            const lbl = currentInputEl.nextElementSibling;
            if (lbl && lbl.classList.contains('custom-file-label')) {
                lbl.textContent = fileName;
            }

            /* Update teks label di wali view jika ada */
            const uploadLabel = currentInputEl.closest('.photo-upload-area')?.querySelector('.photo-upload-label');
            if (uploadLabel) {
                uploadLabel.innerHTML = '<i class="fas fa-check-circle" style="color:#10b981;"></i> Foto telah di-crop — klik untuk ganti';
            }

            /* Sembunyikan ikon placeholder jika ada */
            const uploadIcon = currentInputEl.closest('.photo-upload-area')?.querySelector('.photo-upload-icon');
            if (uploadIcon) uploadIcon.style.display = 'none';

            /* Update preview di header avatar (khusus wali edit) */
            if (currentMode === 'foto') {
                const headerAvatar = document.getElementById('headerAvatar');
                if (headerAvatar && headerAvatar.tagName === 'IMG') {
                    headerAvatar.src = previewUrl;
                } else if (headerAvatar) {
                    /* Masih span, ganti dengan img */
                    const newImg = document.createElement('img');
                    newImg.src = previewUrl;
                    newImg.id  = 'headerAvatar';
                    newImg.style.cssText = 'width:100%;height:100%;object-fit:cover;border-radius:50%;';
                    headerAvatar.replaceWith(newImg);
                }
            }

            btn.disabled  = false;
            btn.innerHTML = '<i class="fas fa-scissors"></i> Crop &amp; Gunakan Foto Ini';
            closeCropModal(false);
        }, currentMode === 'kk' ? 'image/jpeg' : 'image/jpeg', 0.92);
    });

    /* ─── API publik: daftarkan input ─── */
    /**
     * Daftarkan satu input file ke sistem crop.
     * @param {string|HTMLElement} inputSel   - id string atau elemen input
     * @param {string}             previewSel - CSS selector elemen preview
     * @param {'foto'|'kk'}        mode       - tipe crop
     */
    window.registerCropInput = function (inputSel, previewSel, mode) {
        const input = (typeof inputSel === 'string')
            ? document.getElementById(inputSel) || document.querySelector(inputSel)
            : inputSel;
        if (!input) return;

        input.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                openCropModal(this.files[0], this, previewSel, mode);
            }
        });
    };

})();
</script>
@endpush
@endonce
