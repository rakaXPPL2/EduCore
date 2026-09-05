<button class="coach-launcher" id="coachLauncher" aria-label="Buka EduCoach">
    <span class="coach-launcher-spark">✦</span>
    <span><strong>EduCoach</strong><small>Teman progresmu</small></span>
    <i class="coach-pulse"></i>
</button>

<section class="coach-window" id="coachWindow" aria-label="EduCoach" aria-hidden="true">
    <header class="coach-header">
        <div class="coach-avatar">✦</div>
        <div><strong>EduCoach</strong><small>Teman belajar yang bantu kamu berkembang</small></div>
        <button class="coach-close" id="coachClose" aria-label="Tutup EduCoach">&times;</button>
    </header>
    <div class="coach-tabs" role="tablist">
        <button class="coach-tab is-active" data-coach-tab="chat">Tanya coach</button>
        <button class="coach-tab" data-coach-tab="progress">Progress saya</button>
    </div>
    <div class="coach-panel is-active" data-coach-panel="chat">
        <div class="coach-message coach-message-bot"><span class="message-mark">✦</span><div>Hai Aditya! Aku sudah melihat progres belajarmu. Mau tahu tugas mana yang perlu diprioritaskan atau skill apa yang bisa kamu kembangkan?</div></div>
        <div class="coach-suggestions"><button data-coach-question="Skill apa yang perlu aku tingkatkan?">Skill yang perlu ditingkatkan</button><button data-coach-question="Aku cocok kuliah di bidang apa?">Rekomendasi arah kuliah</button><button data-coach-question="Tugas mana yang harus dikerjakan dulu?">Prioritas tugas</button></div>
        <div class="coach-conversation" id="coachConversation"></div>
        <form class="coach-form" id="coachForm"><input id="coachInput" autocomplete="off" placeholder="Tanya tentang progres belajarmu..." maxlength="1000"><button type="submit" aria-label="Kirim pesan">&uarr;</button></form>
        <p class="coach-disclaimer">EduCoach memberi arahan, bukan keputusan final tentang masa depanmu.</p>
    </div>
    <div class="coach-panel" data-coach-panel="progress">
        <div class="coach-progress-intro"><span class="eyebrow">RINGKASAN TERKINI</span><h3>Pelan-pelan, tapi terus naik.</h3><p>Ini peta kecil untuk membantumu melihat langkah berikutnya.</p></div>
        <div class="coach-score"><div><strong>72%</strong><small>kesiapan belajar</small></div><div class="progress-track"><i style="width:72%"></i></div></div>
        <div class="coach-insight-list"><article><span class="insight-icon blue">↗</span><div><strong>Yang sudah kuat</strong><p>Rata-rata nilai 88.6 dan 96% kehadiran.</p></div></article><article><span class="insight-icon orange">!</span><div><strong>Fokus berikutnya</strong><p>Selesaikan 3 tugas yang masih tertunda.</p></div></article><article><span class="insight-icon mint">⌁</span><div><strong>Arah yang mungkin</strong><p>Informatika, Sistem Informasi, atau Rekayasa Perangkat Lunak.</p></div></article></div>
    </div>
</section>
