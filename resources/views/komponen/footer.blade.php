<!-- Link Font Awesome -->
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
                <li><a href="beranda">Beranda</a></li>
                <li><a href="/servis">Servis</a></li>
            </ul>
            <ul>
                <li><a href="#">Status</a></li>
                <li><a href="dashboard#layanan">Layanan</a></li>
            </ul>
            <ul>
                <li><a href="dashboard#dokumen">Panduan</a></li>
                <li><a href="dashboard#tentang">Tentang</a></li>
            </ul>
        </div>
        
        <!-- Tombol WhatsApp -->
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

<style>
.footer {
    margin-left: 70px;
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
    gap: 30px;
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
    flex-wrap: wrap;
}

.footer-links ul {
    list-style: none;
    padding: 0;
    margin: 0;
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
    transition: color 0.3s;
}

.footer-links a:hover {
    color: #00ff85;
    text-decoration: underline;
}

/* Tombol WhatsApp */
.wa-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: #25D366;
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
    justify-content: center;
}

.footer-social a {
    color: #00ff85;
    text-decoration: none;
    transition: color 0.3s;
}

.footer-social a:hover {
    color: white;
}

/* RESPONSIF */
@media (max-width: 768px) {
    .footer {
        margin-left: 0;
        padding: 20px;
        text-align: center;
    }

    .footer-container {
        flex-direction: column;
        align-items: center;
        gap: 25px;
    }

    .footer-left {
        order: 1;
    }

    .footer-links {
        order: 2;
        display: flex;
        flex-wrap: wrap;
        gap: 10px 30px; /* jarak atas-bawah & kiri-kanan */
        justify-content: center;
        max-width: 300px; /* supaya pas 3 kolom */
    }

    .footer-links a {
        font-size: 14px;
    }

    .footer-links ul {
        list-style: none;
        padding: 0;
        margin: 0;
        width: calc(40% - 50px); /* biar 3 link per baris */
        text-align: center;
    }

    .footer-links li {
        margin-bottom: 8px;
    }

    .wa-btn {
        order: 3;
        justify-content: center;
        width: 100%;
        max-width: 250px;
    }

    .footer-logo {
        justify-content: center;
}
}
</style>
