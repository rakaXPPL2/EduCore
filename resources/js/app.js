document.addEventListener("DOMContentLoaded", () => {
    const isTeacherDashboard = window.location.pathname === "/guru/dashboard";
    const isAdminDashboard = window.location.pathname === "/admin/kelas";
    const dashboardTarget =
        document.querySelector(".top-actions") ||
        document.querySelector("header.topbar");

    if (
        (isTeacherDashboard || isAdminDashboard) &&
        dashboardTarget &&
        !dashboardTarget.querySelector(".library-top-link")
    ) {
        const libraryShortcut = document.createElement("a");
        libraryShortcut.className =
            "library-top-link dashboard-library-shortcut";
        libraryShortcut.href = "/perpustakaan";
        libraryShortcut.innerHTML = "<span>▣</span>E-Perpus";
        dashboardTarget.prepend(libraryShortcut);
    }

    const detailModal = document.querySelector("#assignmentModal");
    const permitModal = document.querySelector("#permitModal");
    const toast = document.querySelector("#toast");
    const coachLauncher = document.querySelector("#coachLauncher");
    const coachWindow = document.querySelector("#coachWindow");

    if (coachLauncher && coachWindow) {
        const coachClose = document.querySelector("#coachClose");
        const coachForm = document.querySelector("#coachForm");
        const coachInput = document.querySelector("#coachInput");
        const conversation = document.querySelector("#coachConversation");

        const addMessage = (message, type) => {
            const item = document.createElement("div");
            item.className = `coach-message coach-message-${type}`;
            const content = document.createElement("div");
            content.textContent = message;
            item.appendChild(content);
            conversation.appendChild(item);
            conversation.scrollTop = conversation.scrollHeight;
        };

        const askCoach = async (message) => {
            addMessage(message, "user");
            const loading = document.createElement("div");
            loading.className = "coach-message coach-message-response";
            loading.innerHTML = "<div>Sebentar, aku membaca progresmu...</div>";
            conversation.appendChild(loading);

            try {
                const response = await fetch("/api/student-coach/chat", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                    body: JSON.stringify({ message }),
                });
                const result = await response.json();
                loading.querySelector("div").textContent =
                    result.reply || "Aku belum bisa menemukan jawabannya.";
            } catch {
                loading.querySelector("div").textContent =
                    "Koneksi sedang beristirahat. Coba lagi sebentar.";
            }
        };

        coachLauncher.addEventListener("click", () => {
            const isOpen = coachWindow.classList.toggle("is-open");
            coachWindow.setAttribute("aria-hidden", String(!isOpen));
        });
        coachClose.addEventListener("click", () => {
            coachWindow.classList.remove("is-open");
            coachWindow.setAttribute("aria-hidden", "true");
        });
        document.querySelectorAll("[data-coach-tab]").forEach((tab) => {
            tab.addEventListener("click", () => {
                document
                    .querySelector(".coach-tab.is-active")
                    .classList.remove("is-active");
                document
                    .querySelector(".coach-panel.is-active")
                    .classList.remove("is-active");
                tab.classList.add("is-active");
                document
                    .querySelector(
                        `[data-coach-panel="${tab.dataset.coachTab}"]`,
                    )
                    .classList.add("is-active");
            });
        });
        document
            .querySelectorAll("[data-coach-question]")
            .forEach((button) =>
                button.addEventListener("click", () =>
                    askCoach(button.dataset.coachQuestion),
                ),
            );
        coachForm.addEventListener("submit", (event) => {
            event.preventDefault();
            const message = coachInput.value.trim();
            if (!message) return;
            coachInput.value = "";
            askCoach(message);
        });
    }

    const bookModal = document.querySelector("#bookModal");
    const perpusToast = document.querySelector("#perpusToast");
    const perpusSwal = document.querySelector("#perpusSwal");

    if (perpusSwal) {
        const alertData = document.querySelector(".perpus-alert-data");
        const swalIcon = document.querySelector("#perpusSwalIcon");
        const swalKicker = document.querySelector("#perpusSwalKicker");
        const swalTitle = document.querySelector("#perpusSwalTitle");
        const swalMessage = document.querySelector("#perpusSwalMessage");
        const closeSwal = () => {
            perpusSwal.classList.remove("is-open");
            perpusSwal.setAttribute("aria-hidden", "true");
            document.body.classList.remove("perpus-modal-open");
        };
        perpusSwal
            .querySelectorAll("[data-close-swal]")
            .forEach((element) => element.addEventListener("click", closeSwal));
        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape") closeSwal();
        });
        if (alertData) {
            const isError = alertData.dataset.alertType === "error";
            swalIcon.textContent = isError ? "!" : "✓";
            swalIcon.classList.toggle("is-error", isError);
            swalKicker.textContent = isError
                ? "PERLU DIPERIKSA"
                : "BERHASIL DIUPDATE";
            swalTitle.textContent = isError
                ? "Ada yang perlu diperbaiki"
                : "Aksi berhasil";
            swalMessage.textContent = alertData.dataset.alertMessage;
            window.setTimeout(() => {
                perpusSwal.classList.add("is-open");
                perpusSwal.setAttribute("aria-hidden", "false");
            }, 120);
        }
    }

    if (bookModal) {
        const modalCover = document.querySelector("#bookModalCover");
        const modalCategory = document.querySelector("#bookModalCategory");
        const modalTitle = document.querySelector("#bookModalTitle");
        const modalAuthor = document.querySelector("#bookModalAuthor");
        const modalSynopsis = document.querySelector("#bookModalSynopsis");
        const modalDdc = document.querySelector("#bookModalDdc");
        const modalRack = document.querySelector("#bookModalRack");
        const modalStock = document.querySelector("#bookModalStock");
        const modalAction = document.querySelector("#bookModalAction");
        const closeBookModal = () => {
            bookModal.classList.remove("is-open");
            bookModal.setAttribute("aria-hidden", "true");
            document.body.classList.remove("perpus-modal-open");
        };

        document.querySelectorAll("[data-book-detail]").forEach((button) =>
            button.addEventListener("click", () => {
                modalCover.style.backgroundImage = `url("${button.dataset.cover}")`;
                modalCategory.textContent = button.dataset.category;
                modalTitle.textContent = button.dataset.title;
                modalAuthor.textContent = button.dataset.author;
                modalSynopsis.textContent = button.dataset.synopsis;
                modalDdc.textContent = button.dataset.ddc;
                modalRack.textContent = button.dataset.rack;
                modalStock.textContent =
                    button.dataset.stock > 0
                        ? `${button.dataset.stock} tersedia`
                        : "Stok habis";
                modalAction.innerHTML = button.dataset.loanUrl
                    ? `<form method="POST" action="${button.dataset.loanUrl}"><input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}"><button class="perpus-action perpus-modal-action" type="submit">Ajukan pinjam <span>↗</span></button></form>`
                    : '<span class="perpus-modal-hint">Login sebagai murid untuk mengajukan pinjaman.</span>';
                bookModal.classList.add("is-open");
                bookModal.setAttribute("aria-hidden", "false");
                document.body.classList.add("perpus-modal-open");
            }),
        );

        bookModal
            .querySelectorAll("[data-close-book-modal]")
            .forEach((element) =>
                element.addEventListener("click", closeBookModal),
            );
        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape") closeBookModal();
        });
    }

    if (document.body.classList.contains("perpus-page")) {
        document
            .querySelectorAll("[data-book-card], .perpus-reveal")
            .forEach((element, index) => {
                element.style.setProperty(
                    "--reveal-delay",
                    `${Math.min(index * 45, 360)}ms`,
                );
            });
        const observer = new IntersectionObserver(
            (entries) =>
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("is-visible");
                        observer.unobserve(entry.target);
                    }
                }),
            { threshold: 0.08 },
        );
        document
            .querySelectorAll(".perpus-reveal")
            .forEach((element) => observer.observe(element));
        document.querySelectorAll("[data-due]").forEach((element) => {
            const dueDate = new Date(element.dataset.due);
            const updateCountdown = () => {
                const distance = dueDate - new Date();
                if (distance <= 0) {
                    element.textContent = "Terlambat";
                    element.classList.add("is-overdue");
                    return;
                }
                const days = Math.floor(distance / 86400000);
                element.textContent = `${days} hari lagi`;
            };
            updateCountdown();
            window.setInterval(updateCountdown, 60000);
        });
    }

    const loanSearch = document.querySelector("#loanSearch");
    const loanItems = [...document.querySelectorAll("[data-loan-item]")];
    const loanResult = document.querySelector("#loanResult");
    const loanNoResults = document.querySelector("#loanNoResults");

    if (loanSearch && loanItems.length) {
        let activeLoanFilter = "all";
        const updateLoans = () => {
            const query = loanSearch.value.trim().toLowerCase();
            let visibleCount = 0;

            loanItems.forEach((item) => {
                const matchesQuery =
                    !query || item.dataset.search.includes(query);
                const matchesFilter =
                    activeLoanFilter === "all" ||
                    item.dataset.status === activeLoanFilter;
                const shouldShow = matchesQuery && matchesFilter;
                item.classList.toggle("is-filtered-out", !shouldShow);
                if (shouldShow) {
                    visibleCount += 1;
                    item.style.setProperty(
                        "--loan-in-delay",
                        `${Math.min(visibleCount * 35, 210)}ms`,
                    );
                }
            });

            loanResult.textContent = `${visibleCount} transaksi`;
            loanNoResults.hidden = visibleCount > 0;
        };

        loanSearch.addEventListener("input", updateLoans);
        document.querySelectorAll("[data-loan-filter]").forEach((button) => {
            button.addEventListener("click", () => {
                document
                    .querySelector("[data-loan-filter].is-active")
                    ?.classList.remove("is-active");
                button.classList.add("is-active");
                activeLoanFilter = button.dataset.loanFilter;
                updateLoans();
            });
        });
        document.addEventListener("keydown", (event) => {
            if (
                (event.metaKey || event.ctrlKey) &&
                event.key.toLowerCase() === "k"
            ) {
                event.preventDefault();
                loanSearch.focus();
            }
        });
        updateLoans();
    }

    const catalogSearch = document.querySelector("#catalogSearch");
    const catalogCards = [...document.querySelectorAll("[data-book-card]")];
    const catalogResult = document.querySelector("#catalogResult");
    const catalogNoResults = document.querySelector("#catalogNoResults");

    if (catalogSearch && catalogCards.length) {
        const updateCatalog = () => {
            const query = catalogSearch.value.trim().toLowerCase();
            let visibleCount = 0;

            catalogCards.forEach((card) => {
                const matches =
                    !query || card.dataset.bookSearch.includes(query);
                card.classList.toggle("is-catalog-filtered", !matches);
                if (matches) {
                    visibleCount += 1;
                    card.style.setProperty(
                        "--catalog-in-delay",
                        `${Math.min(visibleCount * 35, 210)}ms`,
                    );
                }
            });

            catalogResult.textContent = `${visibleCount} buku tampil`;
            catalogNoResults.hidden = visibleCount > 0;
        };

        catalogSearch.addEventListener("input", updateCatalog);
        updateCatalog();
    }

    const classLoanForm = document.querySelector("#classLoanForm");
    if (classLoanForm) {
        const selectedCount = document.querySelector("#classLoanCount");
        const checkboxes = [
            ...classLoanForm.querySelectorAll('input[name="book_ids[]"]'),
        ];
        const updateSelectedCount = () => {
            const count = checkboxes.filter(
                (checkbox) => checkbox.checked,
            ).length;
            selectedCount.textContent = `${count}/20 buku dipilih`;
            checkboxes.forEach((checkbox) => {
                checkbox
                    .closest(".perpus-select-book")
                    ?.classList.toggle("is-selected", checkbox.checked);
            });
        };
        checkboxes.forEach((checkbox) =>
            checkbox.addEventListener("change", () => {
                if (checkboxes.filter((item) => item.checked).length > 20)
                    checkbox.checked = false;
                updateSelectedCount();
            }),
        );
        classLoanForm.addEventListener("submit", (event) => {
            if (!checkboxes.some((checkbox) => checkbox.checked)) {
                event.preventDefault();
                selectedCount.textContent = "Pilih minimal 1 buku";
            }
        });
        updateSelectedCount();
    }

    if (!detailModal || !permitModal || !toast) {
        return;
    }

    const detailTitle = document.querySelector("#detailTitle");
    const detailSubject = document.querySelector("#detailSubject");
    const detailDescription = document.querySelector("#detailDescription");
    const detailDue = document.querySelector("#detailDue");
    const detailPoints = document.querySelector("#detailPoints");
    const detailStatus = document.querySelector("#detailStatus");
    const detailUpload = document.querySelector("#detailUpload");
    const fileName = document.querySelector("#fileName");

    const showToast = (message) => {
        toast.querySelector("span").textContent = message;
        toast.classList.add("is-visible");
        window.setTimeout(() => toast.classList.remove("is-visible"), 2800);
    };

    document.querySelectorAll("[data-assignment]").forEach((card) => {
        card.addEventListener("click", () => {
            detailTitle.textContent = card.dataset.title;
            detailSubject.textContent = card.dataset.subject;
            detailDescription.textContent = card.dataset.description;
            detailDue.textContent = card.dataset.due;
            detailPoints.textContent = `${card.dataset.points} poin`;
            detailStatus.textContent = card.dataset.status;
            detailStatus.dataset.tone = card.dataset.tone;
            detailUpload.value = "";
            document.querySelector("#assignmentForm").action =
                `/murid/tugas/${card.dataset.id}/kumpulkan`;
            fileName.textContent = "Pilih file dari perangkat";
            detailModal.classList.add("is-open");
        });
    });

    document.querySelectorAll("[data-close-modal]").forEach((button) => {
        button.addEventListener("click", () =>
            document
                .querySelector(`#${button.dataset.closeModal}`)
                .classList.remove("is-open"),
        );
    });

    document.querySelectorAll(".modal-backdrop").forEach((backdrop) => {
        backdrop.addEventListener("click", (event) => {
            if (event.target === backdrop)
                backdrop.closest(".modal").classList.remove("is-open");
        });
    });

    document
        .querySelector("#openPermit")
        .addEventListener("click", () => permitModal.classList.add("is-open"));
    document
        .querySelector("#detailUpload")
        .addEventListener("change", (event) => {
            fileName.textContent =
                event.target.files[0]?.name || "Pilih file dari perangkat";
        });
    document.querySelector("#assignmentForm").addEventListener("submit", () => {
        detailModal.classList.remove("is-open");
    });
    document
        .querySelector("#permitForm")
        .addEventListener("submit", (event) => {
            permitModal.classList.remove("is-open");
        });

    document.querySelectorAll(".filter-pill").forEach((pill) => {
        pill.addEventListener("click", () => {
            document
                .querySelector(".filter-pill.is-active")
                .classList.remove("is-active");
            pill.classList.add("is-active");
            const filter = pill.dataset.filter;
            document.querySelectorAll("[data-assignment]").forEach((card) => {
                card.hidden = filter !== "all" && card.dataset.state !== filter;
            });
        });
    });

    document.querySelectorAll("[data-nav]").forEach((link) => {
        link.addEventListener("click", (event) => {
            event.preventDefault();
            document
                .querySelector(".side-link.is-active")
                ?.classList.remove("is-active");
            link.classList.add("is-active");
            showToast(
                `${link.dataset.nav} siap digunakan pada tahap berikutnya.`,
            );
        });
    });

    document
        .querySelector("#mobileMenu")
        .addEventListener("click", () =>
            document
                .querySelector(".sidebar")
                .classList.toggle("is-mobile-open"),
        );
});
