    const formInputs = ['name', 'path_img', 'password', 'nmr_telpon'];
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const form = document.getElementById('akunForm');

    const originalData = {};
    formInputs.forEach(id => {
        const input = document.getElementById(id);
        originalData[id] = input?.value || '';
    });

    editBtn.addEventListener('click', () => {
        formInputs.forEach(id => {
            const input = document.getElementById(id);
            if (input) input.removeAttribute('readonly');
        });
        editBtn.classList.add('hidden');
        saveBtn.classList.remove('hidden');
        cancelBtn.classList.remove('hidden');
    });

    cancelBtn.addEventListener('click', () => {
        formInputs.forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                input.setAttribute('readonly', true);
                input.value = originalData[id];
            }
        });
        editBtn.classList.remove('hidden');
        saveBtn.classList.add('hidden');
        cancelBtn.classList.add('hidden');
    });

saveBtn.addEventListener('click', async (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    const res = await fetch(form.action, {
        method: form.method,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: formData
    });
    if (res.ok) {
        const success = document.getElementById('successPopup');
        success.classList.remove('hidden');
        success.addEventListener('click', () => {
            window.location.href = "{{ route('profile') }}";
        }, { once: true });
    } else {
        alert('Gagal menyimpan profil.');
    }
});
