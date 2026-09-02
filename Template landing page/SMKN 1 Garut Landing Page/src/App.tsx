import { useState, useEffect, useRef } from "react";
import logoSmkn from "@/imports/image-2.png";
import logoDisdik from "@/imports/image-3.png";
import buildingMain from "@/imports/image.png";
import buildingAlt from "@/imports/image-1.png";

/* ─── Palette ─────────────────────────────────────────────── */
const C = {
  blue: "#1E90D6",
  blueDark: "#0D6EBD",
  blueDeep: "#0A4F8F",
  blueLight: "#E8F4FD",
  blueMid: "#B3DCEF",
  sky: "#38A9E4",
  white: "#FFFFFF",
  gray50: "#F7FBFF",
  gray100: "#EBF4FC",
  gray600: "#4A6580",
  gray800: "#1A3048",
  navy: "#0B2A45",
};

/* ─── Data ─────────────────────────────────────────────────── */
const jurusan = [
  {
    kode: "AKL",
    nama: "Akuntansi dan Keuangan Lembaga",
    deskripsi: "Mencatat, mengolah, dan menyusun laporan keuangan secara akurat dengan aplikasi komputer akuntansi dan perpajakan.",
    emoji: "💼",
    hue: "#1E90D6",
  },
  {
    kode: "DKV",
    nama: "Desain Komunikasi Visual",
    deskripsi: "Seni visual kreatif — desain grafis, ilustrasi, fotografi, dan videografi untuk kebutuhan industri digital.",
    emoji: "🎨",
    hue: "#7C3AED",
  },
  {
    kode: "MPLB",
    nama: "Manajemen Perkantoran & Layanan Bisnis",
    deskripsi: "Administrasi kantor modern, kearsipan digital, komunikasi bisnis, dan pelayanan prima profesional.",
    emoji: "📋",
    hue: "#0891B2",
  },
  {
    kode: "PMS",
    nama: "Pemasaran",
    deskripsi: "Strategi penjualan, riset pasar, digital marketing, dan pengelolaan toko online maupun offline.",
    emoji: "📊",
    hue: "#EA7C2B",
  },
  {
    kode: "PPLG",
    nama: "Pengembangan Perangkat Lunak & Gim",
    deskripsi: "Pembuatan aplikasi, website, sistem basis data, dan gim interaktif dengan bahasa pemrograman terkini.",
    emoji: "💻",
    hue: "#16A34A",
  },
  {
    kode: "TET",
    nama: "Teknik Energi Terbarukan",
    deskripsi: "Pemanfaatan energi surya dan angin — jurusan unggulan inovasi konversi energi ramah lingkungan.",
    emoji: "⚡",
    hue: "#CA8A04",
  },
  {
    kode: "TJKT",
    nama: "Teknik Jaringan Komputer & Telekomunikasi",
    deskripsi: "Instalasi jaringan, konfigurasi router, dan keamanan sistem untuk menjadi teknisi jaringan handal.",
    emoji: "🌐",
    hue: "#0369A1",
  },
  {
    kode: "TLM",
    nama: "Teknik Laboratorium Medis",
    deskripsi: "Prosedur pengujian sampel klinis untuk mendukung diagnosis medis sebagai analis kesehatan terampil.",
    emoji: "🔬",
    hue: "#DC2626",
  },
];

const stats = [
  { value: "1951", label: "Tahun Berdiri", icon: "🏛️" },
  { value: "8", label: "Kompetensi Keahlian", icon: "📚" },
  { value: "2.400+", label: "Siswa Aktif", icon: "🎓" },
  { value: "120+", label: "Tenaga Pendidik", icon: "👩‍🏫" },
];

const navLinks = [
  { label: "Beranda", href: "#beranda" },
  { label: "Tentang", href: "#tentang" },
  { label: "Jurusan", href: "#jurusan" },
  { label: "Galeri", href: "#galeri" },
  { label: "PPDB", href: "#ppdb" },
  { label: "Kontak", href: "#kontak" },
];

/* ─── App ──────────────────────────────────────────────────── */
export default function App() {
  const [menuOpen, setMenuOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const [activeTab, setActiveTab] = useState(0);
  const heroRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 56);
    window.addEventListener("scroll", onScroll);
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  return (
    <div className="min-h-full bg-white" style={{ fontFamily: "'Poppins', sans-serif" }}>

      {/* ── TOP STRIP ─────────────────────────────────────── */}
      <div style={{ background: C.blueDeep }} className="py-1.5 px-4 text-center">
        <p className="text-white text-[11px] tracking-wide">
          📢 PPDB 2025/2026 Sudah Dibuka — Daftar sekarang via portal PPDB Jawa Barat
        </p>
      </div>

      {/* ── NAVBAR ────────────────────────────────────────── */}
      <nav
        className="sticky top-0 z-50 transition-all duration-300"
        style={{
          background: scrolled ? "rgba(255,255,255,0.96)" : "#FFFFFF",
          borderBottom: `1px solid ${C.blueMid}`,
          backdropFilter: "blur(12px)",
          boxShadow: scrolled ? "0 2px 20px rgba(30,144,214,0.10)" : "none",
        }}
      >
        <div className="max-w-7xl mx-auto px-4 sm:px-6 flex items-center justify-between h-16">
          <a href="#beranda" className="flex items-center gap-3">
            <img src={logoSmkn} alt="Logo SMKN 1 Garut" className="h-11 w-11 object-contain" />
            <div className="leading-tight">
              <div className="font-black text-base" style={{ fontFamily: "'Playfair Display', Georgia, serif", color: C.blueDeep }}>
                SMKN 1 Garut
              </div>
              <div className="text-[10px] tracking-widest uppercase" style={{ color: C.sky }}>
                Motekar Wibawa Mukti
              </div>
            </div>
          </a>

          {/* Desktop */}
          <div className="hidden md:flex items-center gap-0.5">
            {navLinks.map((l) => (
              <a
                key={l.href}
                href={l.href}
                className="text-sm font-medium px-4 py-2 rounded-lg transition-colors duration-200"
                style={{ color: C.gray600 }}
                onMouseEnter={e => { (e.currentTarget as HTMLElement).style.color = C.blue; (e.currentTarget as HTMLElement).style.background = C.blueLight; }}
                onMouseLeave={e => { (e.currentTarget as HTMLElement).style.color = C.gray600; (e.currentTarget as HTMLElement).style.background = "transparent"; }}
              >
                {l.label}
              </a>
            ))}
            <a
              href="#ppdb"
              className="ml-4 text-sm font-bold px-6 py-2.5 rounded-full text-white shadow-md transition-all duration-200"
              style={{ background: `linear-gradient(135deg, ${C.blue}, ${C.blueDeep})`, boxShadow: `0 4px 14px ${C.blue}50` }}
            >
              Daftar PPDB
            </a>
          </div>

          {/* Mobile toggle */}
          <button
            className="md:hidden p-2 rounded-lg"
            style={{ color: C.blue }}
            onClick={() => setMenuOpen(!menuOpen)}
          >
            <svg viewBox="0 0 24 24" fill="none" className="w-6 h-6">
              {menuOpen
                ? <path d="M6 6l12 12M6 18L18 6" stroke="currentColor" strokeWidth="2" strokeLinecap="round" />
                : <path d="M4 7h16M4 12h16M4 17h16" stroke="currentColor" strokeWidth="2" strokeLinecap="round" />}
            </svg>
          </button>
        </div>

        {/* Mobile menu */}
        {menuOpen && (
          <div className="md:hidden px-4 pb-4" style={{ borderTop: `1px solid ${C.blueMid}`, background: "#fff" }}>
            {navLinks.map((l) => (
              <a
                key={l.href}
                href={l.href}
                onClick={() => setMenuOpen(false)}
                className="block py-3 text-sm font-medium border-b"
                style={{ color: C.gray800, borderColor: C.blueLight }}
              >
                {l.label}
              </a>
            ))}
            <a
              href="#ppdb"
              className="mt-4 block text-center font-bold text-sm text-white py-3 rounded-full"
              style={{ background: `linear-gradient(135deg, ${C.blue}, ${C.blueDeep})` }}
            >
              Daftar PPDB
            </a>
          </div>
        )}
      </nav>

      {/* ── HERO ──────────────────────────────────────────── */}
      <section id="beranda" ref={heroRef} className="relative overflow-hidden" style={{ background: `linear-gradient(160deg, ${C.blueLight} 0%, #fff 55%)` }}>
        {/* Decorative circles */}
        <div className="absolute -top-24 -right-24 w-[500px] h-[500px] rounded-full opacity-[0.07]" style={{ background: C.blue }} />
        <div className="absolute top-40 -right-10 w-72 h-72 rounded-full opacity-[0.05]" style={{ background: C.sky }} />
        <div className="absolute -bottom-16 left-8 w-56 h-56 rounded-full opacity-[0.06]" style={{ background: C.blue }} />

        <div className="max-w-7xl mx-auto px-4 sm:px-6 py-16 lg:py-24">
          <div className="grid lg:grid-cols-2 gap-12 items-center">
            {/* Left — Text */}
            <div className="relative z-10">
              {/* Badge */}
              <div
                className="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold mb-6"
                style={{ background: C.blueLight, color: C.blueDark, border: `1px solid ${C.blueMid}` }}
              >
                <span className="w-1.5 h-1.5 rounded-full" style={{ background: C.blue }} />
                Sekolah Menengah Kejuruan Negeri — Garut, Jawa Barat
              </div>

              <h1
                className="font-black leading-[1.06] mb-6"
                style={{
                  fontFamily: "'Playfair Display', Georgia, serif",
                  fontSize: "clamp(2.8rem, 5vw, 4.2rem)",
                  color: C.navy,
                }}
              >
                Raih Masa Depan<br />
                Bersama{" "}
                <span style={{ color: C.blue }}>SMKN 1<br />Garut</span>
              </h1>

              <p className="text-base leading-relaxed mb-3" style={{ color: C.gray600, maxWidth: "460px" }}>
                Mencetak generasi terampil, berkarakter, dan berdaya saing global dengan
                <strong style={{ color: C.blueDeep }}> 8 Kompetensi Keahlian</strong> unggulan sejak 1951.
              </p>
              <p className="text-sm italic font-medium mb-10" style={{ color: C.sky }}>
                "Motekar Wibawa Mukti"
              </p>

              <div className="flex flex-wrap gap-3">
                <a
                  href="#ppdb"
                  className="font-bold text-sm px-7 py-3.5 rounded-full text-white transition-all duration-200 hover:-translate-y-0.5"
                  style={{
                    background: `linear-gradient(135deg, ${C.blue}, ${C.blueDeep})`,
                    boxShadow: `0 6px 24px ${C.blue}45`,
                  }}
                >
                  Daftar PPDB 2025/2026
                </a>
                <a
                  href="#jurusan"
                  className="font-semibold text-sm px-7 py-3.5 rounded-full transition-all duration-200 hover:-translate-y-0.5"
                  style={{ color: C.blue, border: `2px solid ${C.blue}`, background: "#fff" }}
                >
                  Lihat Jurusan →
                </a>
              </div>

              {/* Quick stats inline */}
              <div className="mt-10 flex flex-wrap gap-6">
                {[
                  { val: "1951", desc: "Tahun Berdiri" },
                  { val: "8", desc: "Jurusan" },
                  { val: "2.400+", desc: "Siswa" },
                ].map((s) => (
                  <div key={s.desc}>
                    <div className="font-black text-2xl" style={{ fontFamily: "'Playfair Display', serif", color: C.blue }}>{s.val}</div>
                    <div className="text-xs mt-0.5" style={{ color: C.gray600 }}>{s.desc}</div>
                  </div>
                ))}
              </div>
            </div>

            {/* Right — Photo */}
            <div className="relative">
              {/* Frame decoration */}
              <div
                className="absolute -top-4 -left-4 w-full h-full rounded-3xl"
                style={{ background: `linear-gradient(135deg, ${C.blue}22, ${C.sky}11)`, border: `2px solid ${C.blueMid}` }}
              />
              <div className="relative rounded-3xl overflow-hidden shadow-2xl" style={{ boxShadow: `0 32px 80px ${C.blue}28` }}>
                <img
                  src={buildingMain}
                  alt="Gedung utama SMKN 1 Garut"
                  className="w-full h-[420px] lg:h-[520px] object-cover"
                />
                {/* Gradient overlay bottom */}
                <div className="absolute bottom-0 inset-x-0 h-32" style={{ background: `linear-gradient(to top, ${C.blueDeep}CC, transparent)` }} />
                <div className="absolute bottom-5 left-5 right-5">
                  <p className="text-white font-semibold text-sm">Gedung Utama SMKN 1 Garut</p>
                  <p className="text-white/70 text-xs">Jl. Cimanuk No.309A, Garut</p>
                </div>
              </div>
              {/* Floating logo card */}
              <div
                className="absolute -bottom-5 -left-5 flex items-center gap-3 px-4 py-3 rounded-2xl shadow-xl"
                style={{ background: "#fff", border: `1px solid ${C.blueMid}`, boxShadow: `0 8px 32px ${C.blue}22` }}
              >
                <img src={logoSmkn} alt="Logo SMKN 1 Garut" className="w-12 h-12 object-contain" />
                <div>
                  <p className="text-xs font-bold" style={{ color: C.navy }}>SMKN 1 Garut</p>
                  <p className="text-[10px]" style={{ color: C.sky }}>Akreditasi A</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Wave divider */}
        <div className="w-full overflow-hidden leading-none">
          <svg viewBox="0 0 1440 56" fill="none" xmlns="http://www.w3.org/2000/svg" className="w-full">
            <path d="M0 56C240 20 480 4 720 4C960 4 1200 20 1440 56V56H0V56Z" fill={C.blue} fillOpacity="0.06" />
          </svg>
        </div>
      </section>

      {/* ── STATS BAR ─────────────────────────────────────── */}
      <div style={{ background: `linear-gradient(90deg, ${C.blueDeep}, ${C.blue})` }}>
        <div className="max-w-7xl mx-auto px-4 sm:px-6">
          <div className="grid grid-cols-2 md:grid-cols-4">
            {stats.map((s, i) => (
              <div
                key={s.label}
                className="flex flex-col items-center py-8 px-4 text-center"
                style={{ borderRight: i < 3 ? "1px solid rgba(255,255,255,0.15)" : "none" }}
              >
                <span className="text-2xl mb-1">{s.icon}</span>
                <div className="text-white font-black text-3xl" style={{ fontFamily: "'Playfair Display', serif" }}>{s.value}</div>
                <div className="text-white/70 text-xs mt-1 font-medium tracking-wide uppercase">{s.label}</div>
              </div>
            ))}
          </div>
        </div>
      </div>

      {/* ── TENTANG ───────────────────────────────────────── */}
      <section id="tentang" className="py-24" style={{ background: "#fff" }}>
        <div className="max-w-7xl mx-auto px-4 sm:px-6">
          <div className="grid lg:grid-cols-2 gap-16 items-center">
            {/* Photo collage */}
            <div className="relative h-[480px]">
              <img
                src={buildingAlt}
                alt="Lingkungan SMKN 1 Garut"
                className="absolute inset-0 w-full h-full object-cover rounded-3xl"
                style={{ boxShadow: `0 20px 60px ${C.blue}22` }}
              />
              {/* Blue tint overlay */}
              <div
                className="absolute inset-0 rounded-3xl"
                style={{ background: `linear-gradient(to bottom right, ${C.blue}18, transparent 60%)` }}
              />
              {/* Stripe accent */}
              <div
                className="absolute top-8 right-0 translate-x-3 w-2 h-32 rounded-full"
                style={{ background: `linear-gradient(to bottom, ${C.blue}, ${C.sky})` }}
              />
              {/* Disdik badge */}
              <div
                className="absolute bottom-5 right-5 px-4 py-3 rounded-xl flex items-center gap-2"
                style={{ background: "#fff", border: `1px solid ${C.blueMid}`, boxShadow: `0 4px 20px ${C.blue}20` }}
              >
                <img src={logoDisdik} alt="Disdik Jabar" className="h-8 object-contain" />
                <div>
                  <p className="text-[10px] font-semibold" style={{ color: C.gray600 }}>Binaan</p>
                  <p className="text-xs font-bold" style={{ color: C.blueDeep }}>Disdik Jabar</p>
                </div>
              </div>
            </div>

            {/* Text */}
            <div>
              <p className="text-xs font-bold tracking-widest uppercase mb-3" style={{ color: C.blue }}>Tentang Kami</p>
              <h2
                className="font-black leading-tight mb-6"
                style={{ fontFamily: "'Playfair Display', serif", fontSize: "clamp(2rem, 3.5vw, 3rem)", color: C.navy }}
              >
                Profil <span style={{ color: C.blue }}>SMKN 1 Garut</span>
              </h2>
              <p className="leading-relaxed mb-4 text-sm" style={{ color: C.gray600 }}>
                SMKN 1 Garut merupakan sekolah menengah kejuruan negeri yang berdiri sejak <strong style={{ color: C.blueDeep }}>1951</strong> dan
                berlokasi di jantung Kota Garut, Jawa Barat. Sebagai salah satu SMK tertua dan terkemuka di
                Garut, kami telah menghasilkan ribuan alumni yang berkiprah di berbagai bidang industri nasional
                maupun internasional.
              </p>
              <p className="leading-relaxed mb-8 text-sm" style={{ color: C.gray600 }}>
                Di bawah naungan Dinas Pendidikan Provinsi Jawa Barat, SMKN 1 Garut terus berinovasi dengan
                8 kompetensi keahlian yang relevan dengan kebutuhan industri masa kini dan masa depan.
              </p>

              {/* Visi Misi tabs */}
              <div>
                <div className="flex gap-1 mb-4 p-1 rounded-xl w-fit" style={{ background: C.blueLight }}>
                  {["Visi", "Misi"].map((t, i) => (
                    <button
                      key={t}
                      onClick={() => setActiveTab(i)}
                      className="px-6 py-2 rounded-lg text-sm font-semibold transition-all duration-200"
                      style={{
                        background: activeTab === i ? C.blue : "transparent",
                        color: activeTab === i ? "#fff" : C.gray600,
                        boxShadow: activeTab === i ? `0 2px 12px ${C.blue}44` : "none",
                      }}
                    >
                      {t}
                    </button>
                  ))}
                </div>
                <div className="p-5 rounded-2xl text-sm leading-relaxed" style={{ background: C.gray50, border: `1px solid ${C.blueMid}`, color: C.gray600 }}>
                  {activeTab === 0
                    ? "Menjadi sekolah menengah kejuruan unggulan yang menghasilkan lulusan berkarakter, kompeten, kreatif, inovatif, dan berdaya saing di era global berbasis teknologi dan kearifan lokal."
                    : "Menyelenggarakan pendidikan dan pelatihan vokasi berkualitas, membangun kemitraan industri strategis, mengembangkan karakter luhur siswa, serta mendorong inovasi, kreativitas, dan kewirausahaan yang berdampak bagi masyarakat."}
                </div>
              </div>

              {/* Address */}
              <div
                className="mt-6 flex gap-3 p-4 rounded-xl items-start"
                style={{ background: C.blueLight, border: `1px solid ${C.blueMid}` }}
              >
                <span className="text-xl">📍</span>
                <p className="text-sm" style={{ color: C.gray800 }}>
                  Jl. Cimanuk No.309A, Sukagalih, Kec. Tarogong Kidul,<br />
                  Kabupaten Garut, Jawa Barat 44151
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* ── JURUSAN ───────────────────────────────────────── */}
      <section id="jurusan" className="py-24" style={{ background: C.gray50 }}>
        <div className="max-w-7xl mx-auto px-4 sm:px-6">
          <div className="text-center mb-16">
            <p className="text-xs font-bold tracking-widest uppercase mb-3" style={{ color: C.blue }}>Program Keahlian</p>
            <h2
              className="font-black leading-tight mb-4"
              style={{ fontFamily: "'Playfair Display', serif", fontSize: "clamp(2rem, 4vw, 3rem)", color: C.navy }}
            >
              8 Kompetensi Keahlian
            </h2>
            <p className="text-sm mx-auto leading-relaxed" style={{ color: C.gray600, maxWidth: "520px" }}>
              Pilih jurusan sesuai minat dan bakat Anda. Setiap program dirancang sesuai standar industri
              untuk mempersiapkan karir nyata.
            </p>
          </div>

          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {jurusan.map((j) => (
              <div
                key={j.kode}
                className="group bg-white rounded-2xl p-6 cursor-pointer transition-all duration-300 hover:-translate-y-2"
                style={{
                  border: `1px solid ${C.blueMid}`,
                  boxShadow: "0 2px 12px rgba(30,144,214,0.06)",
                }}
                onMouseEnter={e => {
                  (e.currentTarget as HTMLElement).style.borderColor = j.hue;
                  (e.currentTarget as HTMLElement).style.boxShadow = `0 16px 40px ${j.hue}28`;
                }}
                onMouseLeave={e => {
                  (e.currentTarget as HTMLElement).style.borderColor = C.blueMid;
                  (e.currentTarget as HTMLElement).style.boxShadow = "0 2px 12px rgba(30,144,214,0.06)";
                }}
              >
                {/* Emoji icon in colored circle */}
                <div
                  className="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl mb-5"
                  style={{ background: `${j.hue}14`, border: `1px solid ${j.hue}30` }}
                >
                  {j.emoji}
                </div>

                {/* Kode */}
                <div
                  className="text-[10px] font-black tracking-widest uppercase px-2.5 py-1 rounded-full inline-block mb-3"
                  style={{ background: `${j.hue}12`, color: j.hue }}
                >
                  {j.kode}
                </div>

                <h3 className="font-semibold text-sm leading-snug mb-2" style={{ color: C.navy }}>
                  {j.nama}
                </h3>
                <p className="text-xs leading-relaxed" style={{ color: C.gray600 }}>
                  {j.deskripsi}
                </p>

                {/* Arrow */}
                <div
                  className="mt-4 flex items-center gap-1 text-xs font-semibold transition-colors duration-200"
                  style={{ color: j.hue }}
                >
                  Selengkapnya
                  <svg viewBox="0 0 16 16" fill="none" className="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform">
                    <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
                  </svg>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ── KEUNGGULAN ────────────────────────────────────── */}
      <section className="py-20" style={{ background: `linear-gradient(135deg, ${C.blueDeep} 0%, ${C.blue} 100%)` }}>
        <div className="max-w-7xl mx-auto px-4 sm:px-6">
          <div className="text-center mb-12">
            <p className="text-xs font-bold tracking-widest uppercase mb-3 text-white/70">Mengapa SMKN 1 Garut?</p>
            <h2 className="font-black text-white text-3xl sm:text-4xl" style={{ fontFamily: "'Playfair Display', serif" }}>
              Keunggulan Sekolah
            </h2>
          </div>
          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {[
              { icon: "🏆", title: "Akreditasi A", desc: "Terakreditasi A oleh BAN-SM dengan standar mutu tertinggi" },
              { icon: "🤝", title: "Kemitraan Industri", desc: "Kerja sama dengan 100+ perusahaan nasional dan multinasional" },
              { icon: "🛠️", title: "Lab & Bengkel Modern", desc: "Fasilitas praktik lengkap sesuai standar industri terkini" },
              { icon: "🌟", title: "Alumni Berprestasi", desc: "Ribuan alumni sukses di bidang industri dalam dan luar negeri" },
            ].map((k) => (
              <div
                key={k.title}
                className="p-6 rounded-2xl text-center transition-transform duration-200 hover:-translate-y-1"
                style={{ background: "rgba(255,255,255,0.10)", border: "1px solid rgba(255,255,255,0.18)", backdropFilter: "blur(6px)" }}
              >
                <div className="text-4xl mb-4">{k.icon}</div>
                <h3 className="text-white font-bold text-base mb-2">{k.title}</h3>
                <p className="text-white/70 text-xs leading-relaxed">{k.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ── GALERI ────────────────────────────────────────── */}
      <section id="galeri" className="py-24 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6">
          <div className="text-center mb-14">
            <p className="text-xs font-bold tracking-widest uppercase mb-3" style={{ color: C.blue }}>Galeri</p>
            <h2 className="font-black" style={{ fontFamily: "'Playfair Display', serif", color: C.navy, fontSize: "clamp(1.8rem, 3.5vw, 2.8rem)" }}>
              Lingkungan Sekolah
            </h2>
          </div>
          <div className="grid md:grid-cols-2 gap-6">
            {[
              { src: buildingMain, alt: "Gedung utama SMKN 1 Garut tampak depan", caption: "Gedung Utama", sub: "Tampak Depan" },
              { src: buildingAlt, alt: "Area taman dan lingkungan SMKN 1 Garut", caption: "Lingkungan Sekolah", sub: "Area Taman & Lapangan" },
            ].map((img) => (
              <div
                key={img.caption}
                className="group relative overflow-hidden rounded-2xl aspect-video"
                style={{ boxShadow: `0 8px 32px ${C.blue}18` }}
              >
                <img
                  src={img.src}
                  alt={img.alt}
                  className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                />
                <div
                  className="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                  style={{ background: `linear-gradient(to top, ${C.blueDeep}CC, transparent)` }}
                />
                <div
                  className="absolute bottom-4 left-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                >
                  <p className="text-white font-bold text-sm">{img.caption}</p>
                  <p className="text-white/70 text-xs">{img.sub}</p>
                </div>
                {/* Corner badge */}
                <div
                  className="absolute top-4 left-4 px-3 py-1 rounded-full text-xs font-bold text-white"
                  style={{ background: `${C.blue}CC`, backdropFilter: "blur(4px)" }}
                >
                  {img.caption}
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ── PPDB ──────────────────────────────────────────── */}
      <section id="ppdb" className="py-24" style={{ background: C.gray50 }}>
        <div className="max-w-7xl mx-auto px-4 sm:px-6">
          <div className="text-center mb-16">
            <p className="text-xs font-bold tracking-widest uppercase mb-3" style={{ color: C.blue }}>Penerimaan Siswa Baru</p>
            <h2 className="font-black mb-3" style={{ fontFamily: "'Playfair Display', serif", color: C.navy, fontSize: "clamp(2rem, 4vw, 3rem)" }}>
              PPDB 2025 / 2026
            </h2>
            <p className="text-sm" style={{ color: C.gray600 }}>Bergabunglah dengan ribuan siswa berprestasi di SMKN 1 Garut</p>
          </div>

          <div className="grid lg:grid-cols-2 gap-10">
            {/* Jalur masuk */}
            <div>
              <h3 className="font-bold text-base mb-5" style={{ color: C.navy }}>Jalur Penerimaan</h3>
              <div className="space-y-4">
                {[
                  { jalur: "Jalur Zonasi", persen: "50%", desc: "Berdasarkan jarak domisili ke sekolah", color: C.blue, icon: "🗺️" },
                  { jalur: "Jalur Prestasi", persen: "30%", desc: "Nilai rapor atau prestasi akademik & non-akademik", color: "#16A34A", icon: "🏅" },
                  { jalur: "Jalur Afirmasi", persen: "15%", desc: "Keluarga tidak mampu, dilengkapi PKH/KIP", color: "#EA580C", icon: "🤲" },
                  { jalur: "Jalur Perpindahan", persen: "5%", desc: "Mengikuti perpindahan tugas orang tua/wali", color: "#7C3AED", icon: "📦" },
                ].map((jl) => (
                  <div
                    key={jl.jalur}
                    className="flex gap-4 items-start p-4 bg-white rounded-xl transition-all duration-200"
                    style={{ border: `1px solid ${C.blueMid}`, boxShadow: "0 2px 8px rgba(30,144,214,0.05)" }}
                  >
                    <div
                      className="w-14 h-14 rounded-xl flex flex-col items-center justify-center shrink-0"
                      style={{ background: `${jl.color}14`, border: `1px solid ${jl.color}30` }}
                    >
                      <span className="text-xl">{jl.icon}</span>
                      <span className="text-[10px] font-black mt-0.5" style={{ color: jl.color }}>{jl.persen}</span>
                    </div>
                    <div>
                      <p className="font-bold text-sm mb-1" style={{ color: C.navy }}>{jl.jalur}</p>
                      <p className="text-xs leading-relaxed" style={{ color: C.gray600 }}>{jl.desc}</p>
                    </div>
                  </div>
                ))}
              </div>

              {/* Timeline */}
              <div className="mt-8 p-5 rounded-2xl bg-white" style={{ border: `1px solid ${C.blueMid}` }}>
                <h3 className="font-bold text-sm mb-4" style={{ color: C.navy }}>Jadwal PPDB 2025/2026</h3>
                <div className="space-y-0">
                  {[
                    { fase: "Sosialisasi & Pendataan", waktu: "Mei 2025" },
                    { fase: "Pendaftaran Online", waktu: "Juni 2025" },
                    { fase: "Verifikasi Berkas", waktu: "Juni 2025" },
                    { fase: "Pengumuman Seleksi", waktu: "Juli 2025" },
                    { fase: "Daftar Ulang", waktu: "Juli 2025" },
                    { fase: "Awal Tahun Pelajaran", waktu: "14 Juli 2025" },
                  ].map((t, i, arr) => (
                    <div key={t.fase} className="flex gap-3 items-start">
                      <div className="flex flex-col items-center">
                        <div className="w-2.5 h-2.5 rounded-full mt-1 shrink-0" style={{ background: C.blue }} />
                        {i < arr.length - 1 && <div className="w-px flex-1 mt-1 mb-0" style={{ background: C.blueMid, minHeight: "24px" }} />}
                      </div>
                      <div className="flex justify-between w-full pb-4">
                        <p className="text-xs font-medium" style={{ color: C.gray800 }}>{t.fase}</p>
                        <p className="text-xs font-bold ml-2 shrink-0" style={{ color: C.blue }}>{t.waktu}</p>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            </div>

            {/* Persyaratan */}
            <div className="bg-white rounded-2xl p-8" style={{ border: `1px solid ${C.blueMid}`, boxShadow: `0 8px 32px ${C.blue}10` }}>
              <div className="flex items-center gap-3 mb-6">
                <div className="w-10 h-10 rounded-xl flex items-center justify-center text-xl" style={{ background: C.blueLight }}>📄</div>
                <h3 className="font-bold text-lg" style={{ color: C.navy }}>Persyaratan Dokumen</h3>
              </div>
              <div className="space-y-3">
                {[
                  "Fotokopi Ijazah / SKL SMP/MTs yang telah dilegalisir",
                  "Fotokopi Kartu Keluarga (KK)",
                  "Fotokopi Akta Kelahiran",
                  "Fotokopi Rapor SMP semester 1–5 (dilegalisir)",
                  "Pas foto 3×4 berwarna latar merah (4 lembar)",
                  "Fotokopi Kartu Indonesia Pintar (KIP) jika ada",
                  "Sertifikat prestasi akademik/non-akademik (jalur prestasi)",
                  "Surat Keterangan Pindah Tugas Orang Tua (jalur perpindahan)",
                ].map((req, i) => (
                  <div key={i} className="flex gap-3 items-start">
                    <div
                      className="w-5 h-5 rounded-full flex items-center justify-center shrink-0 mt-0.5"
                      style={{ background: C.blueLight, border: `1px solid ${C.blueMid}` }}
                    >
                      <svg viewBox="0 0 12 12" fill="none" className="w-3 h-3">
                        <path d="M2 6l3 3 5-5" stroke={C.blue} strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
                      </svg>
                    </div>
                    <p className="text-sm leading-relaxed" style={{ color: C.gray600 }}>{req}</p>
                  </div>
                ))}
              </div>

              <div
                className="mt-6 p-4 rounded-xl text-xs leading-relaxed"
                style={{ background: C.blueLight, border: `1px solid ${C.blueMid}`, color: C.blueDeep }}
              >
                <strong>Catatan:</strong> Berkas asli wajib dibawa saat verifikasi. Jadwal mengikuti ketentuan
                PPDB Provinsi Jawa Barat.
              </div>

              <a
                href="https://ppdb.jabarprov.go.id"
                target="_blank"
                rel="noopener noreferrer"
                className="mt-6 flex items-center justify-center gap-2 w-full font-bold text-sm text-white py-3.5 rounded-full transition-all duration-200 hover:-translate-y-0.5"
                style={{
                  background: `linear-gradient(135deg, ${C.blue}, ${C.blueDeep})`,
                  boxShadow: `0 6px 20px ${C.blue}45`,
                }}
              >
                🚀 Daftar via Portal PPDB Jabar
              </a>
            </div>
          </div>
        </div>
      </section>

      {/* ── KONTAK ────────────────────────────────────────── */}
      <section id="kontak" className="py-24 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6">
          <div className="text-center mb-14">
            <p className="text-xs font-bold tracking-widest uppercase mb-3" style={{ color: C.blue }}>Hubungi Kami</p>
            <h2 className="font-black" style={{ fontFamily: "'Playfair Display', serif", color: C.navy, fontSize: "clamp(1.8rem, 3.5vw, 2.8rem)" }}>
              Kontak &amp; Lokasi
            </h2>
          </div>

          <div className="grid lg:grid-cols-3 gap-8">
            <div className="space-y-4">
              {[
                { icon: "📍", label: "Alamat", value: "Jl. Cimanuk No.309A, Sukagalih, Kec. Tarogong Kidul, Kabupaten Garut, Jawa Barat 44151" },
                { icon: "📞", label: "Telepon", value: "(0262) 233 443" },
                { icon: "✉️", label: "Email", value: "smkn1garut@gmail.com" },
                { icon: "🌐", label: "Website", value: "smkn1garut.sch.id" },
              ].map((c) => (
                <div
                  key={c.label}
                  className="flex gap-4 p-5 rounded-xl bg-white transition-all duration-200"
                  style={{ border: `1px solid ${C.blueMid}`, boxShadow: "0 2px 10px rgba(30,144,214,0.06)" }}
                  onMouseEnter={e => { (e.currentTarget as HTMLElement).style.borderColor = C.blue; (e.currentTarget as HTMLElement).style.boxShadow = `0 6px 20px ${C.blue}18`; }}
                  onMouseLeave={e => { (e.currentTarget as HTMLElement).style.borderColor = C.blueMid; (e.currentTarget as HTMLElement).style.boxShadow = "0 2px 10px rgba(30,144,214,0.06)"; }}
                >
                  <div
                    className="w-11 h-11 rounded-xl flex items-center justify-center text-xl shrink-0"
                    style={{ background: C.blueLight }}
                  >
                    {c.icon}
                  </div>
                  <div>
                    <p className="text-xs font-bold uppercase tracking-wide mb-0.5" style={{ color: C.blue }}>{c.label}</p>
                    <p className="text-sm leading-relaxed" style={{ color: C.gray800 }}>{c.value}</p>
                  </div>
                </div>
              ))}
            </div>

            <div className="lg:col-span-2 rounded-2xl overflow-hidden" style={{ border: `1px solid ${C.blueMid}`, boxShadow: `0 8px 32px ${C.blue}14`, minHeight: "420px" }}>
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.8793!2d107.9063!3d-7.2173!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68b9a33ac56543%3A0xe57c0bfb35b47e2a!2sSMKN%201%20Garut!5e0!3m2!1sid!2sid!4v1234567890"
                width="100%"
                height="100%"
                style={{ border: 0, minHeight: "420px" }}
                allowFullScreen
                loading="lazy"
                referrerPolicy="no-referrer-when-downgrade"
                title="Lokasi SMKN 1 Garut"
              />
            </div>
          </div>
        </div>
      </section>

      {/* ── FOOTER ────────────────────────────────────────── */}
      <footer style={{ background: C.navy }}>
        <div className="max-w-7xl mx-auto px-4 sm:px-6 py-14">
          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-10">
            {/* Brand */}
            <div className="lg:col-span-1">
              <div className="flex items-center gap-3 mb-4">
                <img src={logoSmkn} alt="Logo SMKN 1 Garut" className="h-12 w-12 object-contain" />
                <div>
                  <p className="font-black text-white" style={{ fontFamily: "'Playfair Display', serif", fontSize: "1.05rem" }}>SMKN 1 Garut</p>
                  <p className="text-[10px] tracking-widest uppercase" style={{ color: C.sky }}>Motekar Wibawa Mukti</p>
                </div>
              </div>
              <p className="text-sm leading-relaxed mb-5" style={{ color: "rgba(255,255,255,0.5)" }}>
                Mendidik, melatih, dan membentuk generasi terampil berkarakter sejak 1951.
              </p>
              <img src={logoDisdik} alt="Disdik Jabar" className="h-8 object-contain opacity-60" />
            </div>

            {/* Nav */}
            <div>
              <p className="text-white font-semibold text-sm mb-4">Navigasi</p>
              <ul className="space-y-2">
                {navLinks.map((l) => (
                  <li key={l.href}>
                    <a href={l.href} className="text-sm transition-colors duration-200" style={{ color: "rgba(255,255,255,0.5)" }}
                      onMouseEnter={e => ((e.currentTarget as HTMLElement).style.color = C.sky)}
                      onMouseLeave={e => ((e.currentTarget as HTMLElement).style.color = "rgba(255,255,255,0.5)")}
                    >
                      {l.label}
                    </a>
                  </li>
                ))}
              </ul>
            </div>

            {/* Jurusan */}
            <div>
              <p className="text-white font-semibold text-sm mb-4">Kompetensi Keahlian</p>
              <ul className="space-y-2">
                {jurusan.map((j) => (
                  <li key={j.kode} className="flex items-center gap-2">
                    <span className="text-[10px] font-black w-8 shrink-0" style={{ color: C.sky }}>{j.kode}</span>
                    <a href="#jurusan" className="text-xs truncate transition-colors duration-200" style={{ color: "rgba(255,255,255,0.5)" }}
                      onMouseEnter={e => ((e.currentTarget as HTMLElement).style.color = C.sky)}
                      onMouseLeave={e => ((e.currentTarget as HTMLElement).style.color = "rgba(255,255,255,0.5)")}
                    >
                      {j.nama}
                    </a>
                  </li>
                ))}
              </ul>
            </div>

            {/* Sosmed */}
            <div>
              <p className="text-white font-semibold text-sm mb-4">Ikuti Kami</p>
              <div className="flex gap-3 mb-6">
                {[
                  { label: "Instagram", d: "M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" },
                  { label: "YouTube", d: "M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z" },
                  { label: "Facebook", d: "M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" },
                ].map((s) => (
                  <a
                    key={s.label}
                    href="#"
                    aria-label={s.label}
                    className="w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-200"
                    style={{ background: "rgba(255,255,255,0.08)", border: "1px solid rgba(255,255,255,0.12)" }}
                    onMouseEnter={e => { (e.currentTarget as HTMLElement).style.background = C.blue; (e.currentTarget as HTMLElement).style.borderColor = C.blue; }}
                    onMouseLeave={e => { (e.currentTarget as HTMLElement).style.background = "rgba(255,255,255,0.08)"; (e.currentTarget as HTMLElement).style.borderColor = "rgba(255,255,255,0.12)"; }}
                  >
                    <svg viewBox="0 0 24 24" fill="rgba(255,255,255,0.6)" className="w-4 h-4"><path d={s.d} /></svg>
                  </a>
                ))}
              </div>
              <p className="text-white font-semibold text-sm mb-3">Jam Operasional</p>
              {[
                ["Senin – Jumat", "07.00 – 16.00"],
                ["Sabtu", "07.00 – 12.00"],
                ["Minggu", "Tutup"],
              ].map(([hari, jam]) => (
                <div key={hari} className="flex justify-between py-1.5 text-xs" style={{ borderBottom: "1px solid rgba(255,255,255,0.06)" }}>
                  <span style={{ color: "rgba(255,255,255,0.5)" }}>{hari}</span>
                  <span style={{ color: jam === "Tutup" ? "#f87171" : "rgba(255,255,255,0.85)" }}>{jam}</span>
                </div>
              ))}
            </div>
          </div>
        </div>

        <div style={{ borderTop: "1px solid rgba(255,255,255,0.08)" }} className="py-5 px-4">
          <div className="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-xs" style={{ color: "rgba(255,255,255,0.35)" }}>
            <p>&copy; {new Date().getFullYear()} SMKN 1 Garut. Hak Cipta Dilindungi.</p>
            <p>Jl. Cimanuk No.309A, Sukagalih, Tarogong Kidul, Garut, Jawa Barat 44151</p>
          </div>
        </div>
      </footer>
    </div>
  );
}
