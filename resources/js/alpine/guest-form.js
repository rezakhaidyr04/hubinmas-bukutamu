// resources/js/alpine/guest-form.js

export default (config = { requirePhone: '0', requireEmail: '0', customQuestions: [] }) => ({
    step: 1,
    isLoading: false,
    errorMessage: '',
    config: config,
    
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
        custom_answers: {}
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

    // Navigasi
    nextStep() {
        if (this.step === 1 && this.validateStep1()) {
            this.step = 2;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else if (this.step === 2 && this.validateStep2()) {
            this.step = 3;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    },

    prevStep() {
        if (this.step > 1) {
            this.step--;
            this.errorMessage = '';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    },

    setKategori(kategori) {
        this.form.kategori = kategori;
        this.errorMessage = '';
    },

    // Submit ke server
    async submitForm() {
        this.isLoading = true;
        this.errorMessage = '';
        
        try {
            const csrfMeta = document.querySelector('meta[name=\'csrf-token\']');
            const csrfToken = csrfMeta ? csrfMeta.content : '';
            
            // Dummy submit endpoint, later to be replaced by actual Laravel route
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
                // Redirect ke halaman sukses dengan ID kunjungan
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
