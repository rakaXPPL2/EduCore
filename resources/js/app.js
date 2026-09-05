document.addEventListener('DOMContentLoaded', () => {
	const detailModal = document.querySelector('#assignmentModal');
	const permitModal = document.querySelector('#permitModal');
	const toast = document.querySelector('#toast');
	const detailTitle = document.querySelector('#detailTitle');
	const detailSubject = document.querySelector('#detailSubject');
	const detailDescription = document.querySelector('#detailDescription');
	const detailDue = document.querySelector('#detailDue');
	const detailPoints = document.querySelector('#detailPoints');
	const detailStatus = document.querySelector('#detailStatus');
	const detailUpload = document.querySelector('#detailUpload');
	const fileName = document.querySelector('#fileName');

	const assignments = {
		'matematika': {
			title: 'Eksplorasi Fungsi Kuadrat', subject: 'Matematika', description: 'Buat rangkuman konsep fungsi kuadrat dan selesaikan lima soal aplikasi pada lembar kerja.', due: 'Besok, 23:59', points: '100 poin', status: 'Belum dikerjakan', tone: 'blue'
		},
		'basis-data': {
			title: 'Normalisasi Basis Data', subject: 'Basis Data', description: 'Analisis tabel transaksi yang diberikan, lalu ubah menjadi bentuk normal ketiga beserta relasinya.', due: '12 Sep 2026, 23:59', points: '80 poin', status: 'Belum dikerjakan', tone: 'violet'
		},
		'bahasa-indonesia': {
			title: 'Menulis Teks Eksposisi', subject: 'Bahasa Indonesia', description: 'Tulis teks eksposisi bertema teknologi hijau dengan struktur tesis, argumentasi, dan penegasan ulang.', due: '14 Sep 2026, 16:00', points: '100 poin', status: 'Sudah dikumpulkan', tone: 'mint'
		},
		'pemrograman': {
			title: 'Mini Project: Landing Page', subject: 'Pemrograman Web', description: 'Kembangkan landing page responsif menggunakan HTML dan CSS. Sertakan screenshot hasil akhir.', due: '18 Sep 2026, 23:59', points: '120 poin', status: 'Belum dikerjakan', tone: 'orange'
		}
	};

	const showToast = (message) => {
		toast.querySelector('span').textContent = message;
		toast.classList.add('is-visible');
		window.setTimeout(() => toast.classList.remove('is-visible'), 2800);
	};

	document.querySelectorAll('[data-assignment]').forEach((card) => {
		card.addEventListener('click', () => {
			const assignment = assignments[card.dataset.assignment];
			detailTitle.textContent = assignment.title;
			detailSubject.textContent = assignment.subject;
			detailDescription.textContent = assignment.description;
			detailDue.textContent = assignment.due;
			detailPoints.textContent = assignment.points;
			detailStatus.textContent = assignment.status;
			detailStatus.dataset.tone = assignment.tone;
			detailUpload.value = '';
			fileName.textContent = 'Pilih file dari perangkat';
			detailModal.classList.add('is-open');
		});
	});

	document.querySelectorAll('[data-close-modal]').forEach((button) => {
		button.addEventListener('click', () => document.querySelector(`#${button.dataset.closeModal}`).classList.remove('is-open'));
	});

	document.querySelectorAll('.modal-backdrop').forEach((backdrop) => {
		backdrop.addEventListener('click', (event) => {
			if (event.target === backdrop) backdrop.closest('.modal').classList.remove('is-open');
		});
	});

	document.querySelector('#openPermit').addEventListener('click', () => permitModal.classList.add('is-open'));
	document.querySelector('#detailUpload').addEventListener('change', (event) => {
		fileName.textContent = event.target.files[0]?.name || 'Pilih file dari perangkat';
	});
	document.querySelector('#assignmentForm').addEventListener('submit', (event) => {
		event.preventDefault();
		detailModal.classList.remove('is-open');
		showToast('Tugas berhasil dikumpulkan sebagai draft demo.');
	});
	document.querySelector('#permitForm').addEventListener('submit', (event) => {
		event.preventDefault();
		permitModal.classList.remove('is-open');
		event.target.reset();
		showToast('Pengajuan izin tersimpan sebagai draft demo.');
	});

	document.querySelectorAll('.filter-pill').forEach((pill) => {
		pill.addEventListener('click', () => {
			document.querySelector('.filter-pill.is-active').classList.remove('is-active');
			pill.classList.add('is-active');
			const filter = pill.dataset.filter;
			document.querySelectorAll('[data-assignment]').forEach((card) => {
				card.hidden = filter !== 'all' && card.dataset.state !== filter;
			});
		});
	});

	document.querySelectorAll('[data-nav]').forEach((link) => {
		link.addEventListener('click', (event) => {
			event.preventDefault();
			document.querySelector('.side-link.is-active')?.classList.remove('is-active');
			link.classList.add('is-active');
			showToast(`${link.dataset.nav} siap digunakan pada tahap berikutnya.`);
		});
	});

	document.querySelector('#mobileMenu').addEventListener('click', () => document.querySelector('.sidebar').classList.toggle('is-mobile-open'));
});
