// Day 5: live form validation, name auto-uppercase, digits-only phone input,
// Bootstrap delete modal, and client-side sorting of the currently visible rows.
document.addEventListener('DOMContentLoaded', () => {
  const nameInput = document.getElementById('name');
  const phoneInput = document.getElementById('phone');
  const emailInput = document.getElementById('email');
  const form = document.getElementById('entryForm');

  if (nameInput) {
    nameInput.addEventListener('input', () => {
      const start = nameInput.selectionStart;
      const end = nameInput.selectionEnd;
      nameInput.value = nameInput.value.toUpperCase();
      if (typeof start === 'number') nameInput.setSelectionRange(start, end);
      nameInput.classList.toggle('is-valid', nameInput.value.trim().length >= 3);
      nameInput.classList.toggle('is-invalid', nameInput.value.trim().length > 0 && nameInput.value.trim().length < 3);
    });
  }
  if (phoneInput) {
    phoneInput.addEventListener('input', () => {
      const start = phoneInput.selectionStart;
      phoneInput.value = phoneInput.value.replace(/[^0-9]/g, '').slice(0, 15);
      if (typeof start === 'number') phoneInput.setSelectionRange(phoneInput.value.length, phoneInput.value.length);
      phoneInput.classList.toggle('is-valid', /^[0-9]{7,15}$/.test(phoneInput.value));
      phoneInput.classList.toggle('is-invalid', phoneInput.value.length > 0 && !/^[0-9]{7,15}$/.test(phoneInput.value));
    });
  }
  if (emailInput) emailInput.addEventListener('input', () => {
    emailInput.classList.toggle('is-valid', emailInput.value !== '' && emailInput.checkValidity());
    emailInput.classList.toggle('is-invalid', emailInput.value !== '' && !emailInput.checkValidity());
  });
  if (form) form.addEventListener('submit', (event) => {
    if (nameInput) nameInput.value = nameInput.value.trim();
    if (emailInput) emailInput.value = emailInput.value.trim();
    const nameOk = nameInput && nameInput.value.length >= 3;
    const emailOk = emailInput && emailInput.checkValidity();
    const phoneOk = phoneInput && /^[0-9]{7,15}$/.test(phoneInput.value);
    if (!nameOk || !emailOk || !phoneOk) {
      event.preventDefault();
      form.classList.add('was-validated');
      if (nameInput && !nameOk) nameInput.classList.add('is-invalid');
      if (emailInput && !emailOk) emailInput.classList.add('is-invalid');
      if (phoneInput && !phoneOk) phoneInput.classList.add('is-invalid');
      const firstInvalid = form.querySelector(':invalid');
      if (firstInvalid) firstInvalid.focus();
    }
  });

  const deleteModal = document.getElementById('deleteModal');
  if (deleteModal) deleteModal.addEventListener('show.bs.modal', (event) => {
    const button = event.relatedTarget;
    if (!button) return;
    document.getElementById('deleteEntryId').value = button.getAttribute('data-entry-id') || '';
    document.getElementById('deleteEntryName').textContent = button.getAttribute('data-entry-name') || 'this entry';
  });
});

function sortTable(columnIndex) {
  const table = document.getElementById('entriesTable');
  if (!table || !table.tBodies.length) return;
  const tbody = table.tBodies[0];
  const rows = Array.from(tbody.rows).filter(row => row.cells.length > columnIndex);
  if (rows.length < 2) return;
  const headers = table.tHead.rows[0].cells;
  const current = headers[columnIndex].getAttribute('data-sort-direction') || 'asc';
  const direction = current === 'asc' ? 'desc' : 'asc';
  Array.from(headers).forEach(header => header.removeAttribute('data-sort-direction'));
  headers[columnIndex].setAttribute('data-sort-direction', direction);
  rows.sort((a, b) => {
    const cellA = a.cells[columnIndex]; const cellB = b.cells[columnIndex];
    const aValue = cellA.getAttribute('data-sort-value') || cellA.textContent.trim();
    const bValue = cellB.getAttribute('data-sort-value') || cellB.textContent.trim();
    const aNum = Number(aValue); const bNum = Number(bValue);
    const bothNumeric = aValue !== '' && bValue !== '' && Number.isFinite(aNum) && Number.isFinite(bNum);
    const comparison = bothNumeric ? aNum - bNum : aValue.localeCompare(bValue, undefined, {numeric: true, sensitivity: 'base'});
    return direction === 'asc' ? comparison : -comparison;
  });
  rows.forEach(row => tbody.appendChild(row));
}
