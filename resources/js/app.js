document.addEventListener('DOMContentLoaded', () => {
	const detailModal = document.querySelector('#assignmentModal');
	const permitModal = document.querySelector('#permitModal');
	const toast = document.querySelector('#toast');
	const coachLauncher = document.querySelector('#coachLauncher');
	const coachWindow = document.querySelector('#coachWindow');

	if (coachLauncher && coachWindow) {
		const coachClose = document.querySelector('#coachClose');
		const coachForm = document.querySelector('#coachForm');
		const coachInput = document.querySelector('#coachInput');
		const conversation = document.querySelector('#coachConversation');

		const addMessage = (message, type) => {
			const item = document.createElement('div');
			item.className = `coach-message coach-message-${type}`;
			const content = document.createElement('div');
			content.textContent = message;
			item.appendChild(content);
			conversation.appendChild(item);
			conversation.scrollTop = conversation.scrollHeight;
		};

		const askCoach = async (message) => {
			addMessage(message, 'user');
			const loading = document.createElement('div');
			loading.className = 'coach-message coach-message-response';
			loading.innerHTML = '<div>Sebentar, aku membaca progresmu...</div>';
			conversation.appendChild(loading);

			try {
				const response = await fetch('/api/student-coach/chat', {
					method: 'POST',
					headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
					body: JSON.stringify({ message }),
				});
				const result = await response.json();
				loading.querySelector('div').textContent = result.reply || 'Aku belum bisa menemukan jawabannya.';
			} catch {
				loading.querySelector('div').textContent = 'Koneksi sedang beristirahat. Coba lagi sebentar.';
			}
		};

		coachLauncher.addEventListener('click', () => {
			const isOpen = coachWindow.classList.toggle('is-open');
			coachWindow.setAttribute('aria-hidden', String(!isOpen));
		});
		coachClose.addEventListener('click', () => {
			coachWindow.classList.remove('is-open');
			coachWindow.setAttribute('aria-hidden', 'true');
		});
		document.querySelectorAll('[data-coach-tab]').forEach((tab) => {
			tab.addEventListener('click', () => {
				document.querySelector('.coach-tab.is-active').classList.remove('is-active');
				document.querySelector('.coach-panel.is-active').classList.remove('is-active');
				tab.classList.add('is-active');
				document.querySelector(`[data-coach-panel="${tab.dataset.coachTab}"]`).classList.add('is-active');
			});
		});
		document.querySelectorAll('[data-coach-question]').forEach((button) => button.addEventListener('click', () => askCoach(button.dataset.coachQuestion)));
		coachForm.addEventListener('submit', (event) => {
			event.preventDefault();
			const message = coachInput.value.trim();
			if (!message) return;
			coachInput.value = '';
			askCoach(message);
		});
	}

	if (!detailModal || !permitModal || !toast) {
		return;
	}

	const detailTitle = document.querySelector('#detailTitle');
	const detailSubject = document.querySelector('#detailSubject');
	const detailDescription = document.querySelector('#detailDescription');
	const detailDue = document.querySelector('#detailDue');
	const detailPoints = document.querySelector('#detailPoints');
	const detailStatus = document.querySelector('#detailStatus');
	const detailUpload = document.querySelector('#detailUpload');
	const fileName = document.querySelector('#fileName');

	const showToast = (message) => {
		toast.querySelector('span').textContent = message;
		toast.classList.add('is-visible');
		window.setTimeout(() => toast.classList.remove('is-visible'), 2800);
	};

	document.querySelectorAll('[data-assignment]').forEach((card) => {
		card.addEventListener('click', () => {
			detailTitle.textContent = card.dataset.title;
			detailSubject.textContent = card.dataset.subject;
			detailDescription.textContent = card.dataset.description;
			detailDue.textContent = card.dataset.due;
			detailPoints.textContent = `${card.dataset.points} poin`;
			detailStatus.textContent = card.dataset.status;
			detailStatus.dataset.tone = card.dataset.tone;
			detailUpload.value = '';
			 document.querySelector('#assignmentForm').action = `/murid/tugas/${card.dataset.id}/kumpulkan`;
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
	document.querySelector('#assignmentForm').addEventListener('submit', () => {
		detailModal.classList.remove('is-open');
	});
	document.querySelector('#permitForm').addEventListener('submit', (event) => {
		permitModal.classList.remove('is-open');
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
