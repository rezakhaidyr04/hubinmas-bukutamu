// resources/js/alpine/guest-form.js

export default (config = { requirePhone: '0', requireEmail: '0', customQuestions: [] }) => ({
    step: 1,
    isLoading: false,
    errorMessage: '',
    config: config,
    _signaturePad: null,
    
    // Data Form
    form: {
        kategori: '',
        nama_lengkap: '',
        asal_instansi: '',
        tujuan_bertemu: '',
        tujuan_bertemu_lainnya: '',
        keperluan: '',
        no_telepon: '',
        email: '',
        custom_answers: {},
        signature: ''
    },

    // Validasi per step
    validateStep1() {
        if (!this.form.kategori) {
            this.errorMessage = 'Silakan pilih kategori tamu terlebih dahulu.';
            return false;
        }
        this.errorMessage = '';
        return true;
    },

    getResolvedTujuanBertemu() {
        if (this.form.tujuan_bertemu === 'Lainnya') {
            return (this.form.tujuan_bertemu_lainnya || '').trim();
        }
        return (this.form.tujuan_bertemu || '').trim();
    },

    validateStep2() {
        const tujuanBertemu = this.getResolvedTujuanBertemu();

        if (!this.form.nama_lengkap || !this.form.asal_instansi || !tujuanBertemu || !this.form.keperluan) {
            this.errorMessage = 'Mohon lengkapi semua data wajib (bertanda bintang merah).';
            return false;
        }

        if (this.form.tujuan_bertemu === 'Lainnya' && !this.form.tujuan_bertemu_lainnya.trim()) {
            this.errorMessage = 'Mohon isi tujuan / pihak yang dituju secara manual.';
            return false;
        }
        if (this.config.requirePhone === '1' && !this.form.no_telepon) {
            this.errorMessage = 'No. Telepon / WhatsApp wajib diisi.';
            return false;
        }
        if (this.config.requireEmail === '1' && !this.form.email) {
            this.errorMessage = 'Email wajib diisi.';
            return false;
        }

        // Validasi pertanyaan kustom
        if (Array.isArray(this.config.customQuestions)) {
            for (const cq of this.config.customQuestions) {
                if (cq.label && cq.required) {
                    const ans = (this.form.custom_answers[cq.label] || '').toString().trim();
                    if (!ans) {
                        this.errorMessage = `Pertanyaan '${cq.label}' wajib diisi.`;
                        return false;
                    }
                }
            }
        }

        this.errorMessage = '';
        return true;
    },

    // Inisialisasi Signature Pad setelah step 3 ditampilkan
    initSignaturePad() {
        this.$nextTick(() => {
            const canvas = document.getElementById('signature-canvas');
            if (!canvas || this._signaturePad) return;

            // Set canvas size to match display size
            const wrapper = document.getElementById('signature-pad-wrapper');
            canvas.width = wrapper ? wrapper.offsetWidth : 400;
            canvas.height = 160;

            this._signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgba(248, 250, 252, 1)',
                penColor: '#1e293b',
                minWidth: 1.5,
                maxWidth: 3,
            });

            // Hide placeholder when user begins signing
            const placeholder = document.getElementById('signature-placeholder');
            this._signaturePad.addEventListener('beginStroke', () => {
                if (placeholder) placeholder.style.display = 'none';
            });

            // Clear button
            const clearBtn = document.getElementById('clear-signature-btn');
            if (clearBtn) {
                clearBtn.addEventListener('click', () => {
                    this._signaturePad.clear();
                    if (placeholder) placeholder.style.display = 'flex';
                    this.form.signature = '';
                    const errEl = document.getElementById('signature-error');
                    if (errEl) errEl.classList.add('hidden');
                });
            }
        });
    },

    // Navigasi
    nextStep() {
        if (this.step === 1 && this.validateStep1()) {
            this.step = 2;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else if (this.step === 2 && this.validateStep2()) {
            this.step = 3;
            this._signaturePad = null; // reset so it re-inits fresh
            window.scrollTo({ top: 0, behavior: 'smooth' });
            this.initSignaturePad();
        }
    },

    prevStep() {
        if (this.step > 1) {
            this.step--;
            this.errorMessage = '';
            this._signaturePad = null;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    },

    setKategori(kategori) {
        this.form.kategori = kategori;
        this.errorMessage = '';
    },

    // Submit ke server
    async submitForm() {
        // Validasi tanda tangan wajib diisi
        const errEl = document.getElementById('signature-error');
        if (!this._signaturePad || this._signaturePad.isEmpty()) {
            if (errEl) errEl.classList.remove('hidden');
            return;
        }
        if (errEl) errEl.classList.add('hidden');

        // Ambil data tanda tangan sebagai base64 PNG
        this.form.signature = this._signaturePad.toDataURL('image/png');

        this.isLoading = true;
        this.errorMessage = '';
        
        try {
            const csrfMeta = document.querySelector('meta[name=\'csrf-token\']');
            const csrfToken = csrfMeta ? csrfMeta.content : '';
            
            const payload = {
                ...this.form,
                tujuan_bertemu: this.getResolvedTujuanBertemu(),
            };
            delete payload.tujuan_bertemu_lainnya;

            const response = await fetch('/guestbook/submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(payload)
            });

            if (response.ok) {
                const data = await response.json();
                window.location.href = `/guestbook/success?id=${data.id_kunjungan}`;
            } else {
                const data = await response.json();
                this.errorMessage = data.message || 'Terjadi kesalahan saat menyimpan data.';
            }
        } catch (error) {
            this.errorMessage = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
        } finally {
            this.isLoading = false;
        }
    }
});
