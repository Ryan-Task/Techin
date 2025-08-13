<!-- Link Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<footer class="footer">
    <div class="footer-container">
        
        <!-- Bagian Kiri -->
        <div class="footer-left">
            <div class="footer-logo">
                <i class="fa-solid fa-robot"></i>
                <span>Techin</span>
            </div>
            <p class="footer-copy">Copyright &copy; 2025</p>
            <p class="footer-tagline">Tempat servis terbaik dan tercepat</p>
        </div>
        
        <!-- Bagian Tengah -->
        <div class="footer-links">
            <ul>
                <li><a href="dashboard">Beranda</a></li>
                <li><a href="/servis">Servis</a></li>
            </ul>
            <ul>
                <li><a href="#">Cek Status</a></li>
                <li><a href="dashboard#layanan">Layanan</a></li>
            </ul>
            <ul>
                <li><a href="dashboard#dokumen">Panduan</a></li>
                <li><a href="dashboard#tentang">Tentang</a></li>
            </ul>
        </div>
        
        <a href="https://wa.me/6281234567890" target="_blank" class="wa-btn">
                 Hubungi Kami <i class="fa-brands fa-whatsapp"></i>
        </a>
    </div>
    
    <hr class="footer-line">
    
    <!-- Bagian Sosial Media -->
    <div class="footer-social">
        <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
        <a href="#"><i class="fa-brands fa-instagram"></i></a>
        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
    </div>
</footer>

<style>
.footer {
    margin-left: 70px; /* sesuaikan jika ada sidebar */
    background-color: #024e4e;
    color: white;
    padding: 30px 50px;
    font-family: Arial, sans-serif;
}

.footer-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
}

/* Logo & teks kiri */
.footer-logo {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 18px;
    font-weight: bold;
}

.footer-copy {
    margin-top: 10px;
    font-size: 14px;
}

.footer-tagline {
    font-size: 12px;
    color: #ccc;
}

/* Link tengah */
.footer-links {
    display: flex;
    gap: 50px;
}

.footer-links ul {
    list-style: none;
    padding: 0;
}

.footer-links li {
    margin-bottom: 8px;
}

.footer-links a {
    color: white;
    text-decoration: none;
    font-size: 14px;
    border-left: 2px solid #00a676;
    padding-left: 8px;
}

.footer-links a:hover {
    text-decoration: underline;
}

/* Tombol kanan */
.contact-btn {
    background-color: #ff8c78;
    padding: 10px 18px;
    color: black;
    text-decoration: none;
    border-radius: 6px;
    font-weight: bold;
}

.contact-btn:hover {
    background-color: #ff7a64;
}

/* Garis bawah */
.footer-line {
    border: none;
    border-top: 1px solid white;
    margin: 20px 0;
}

/* Sosial media */
.footer-social {
    display: flex;
    gap: 15px;
    font-size: 20px;
}

.footer-social a {
    color: #00ff85;
    text-decoration: none;
}

.footer-social a:hover {
    color: white;
}

.wa-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: #25D366; /* hijau WhatsApp */
    color: white;
    padding: 10px 16px;
    font-size: 16px;
    font-weight: bold;
    text-decoration: none;
    border-radius: 6px;
    transition: background-color 0.3s ease;
}

.wa-btn i {
    font-size: 18px;
}

.wa-btn:hover {
    background-color: #1ebe5d;
}
</style>
