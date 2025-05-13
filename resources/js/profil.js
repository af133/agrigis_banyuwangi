const formInputs = ['name', 'email', 'password']; 
const editBtn = document.getElementById('editBtn');
const saveBtn = document.getElementById('saveBtn');
const cancelBtn = document.getElementById('cancelBtn');
const form = document.getElementById('akunForm');

const originalData = {};
formInputs.forEach(id => {
    originalData[id] = document.getElementById(id).value;
});

editBtn.addEventListener('click', () => {
    formInputs.forEach(id => {
        document.getElementById(id).removeAttribute('readonly');
    });
    editBtn.classList.add('hidden');
    saveBtn.classList.remove('hidden');
    cancelBtn.classList.remove('hidden');
});

cancelBtn.addEventListener('click', () => {
    formInputs.forEach(id => {
        const input = document.getElementById(id);
        input.setAttribute('readonly', true);
        input.value = originalData[id];
    });
    editBtn.classList.remove('hidden');
    saveBtn.classList.add('hidden');
    cancelBtn.classList.add('hidden');
});

form.addEventListener('submit', function (e) {
    const confirmation = confirm('Apakah data yang diubah sudah sesuai?');
    if (!confirmation) {
        e.preventDefault();
        return;
    }

    setTimeout(() => {
        window.location.href = "{{ route('profile') }}";
    }, 500);
});