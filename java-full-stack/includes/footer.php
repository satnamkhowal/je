<footer class="site-footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand"><img src="../assets/images/jaipur Engineers logo in white color.png" alt="Jaipur Engineers"><p>Practical IT training, internship and staffing ecosystem in Jaipur, carrying a learning legacy that began in 1996.</p></div>
      <div class="footer-col"><h4>Course</h4><a href="#overview">Overview</a><a href="#curriculum">Curriculum</a><a href="#mentors">Mentors</a><a href="#batches">Batches</a></div>
      <div class="footer-col"><h4>Resources</h4><a href="#reviews">Reviews</a><a href="#faq">FAQs</a><a href="<?= htmlspecialchars($je['website']) ?>" target="_blank" rel="noopener">Main Website</a></div>
      <div class="footer-contact"><h4>Jaipur Engineers</h4><p><i class="fa fa-map-marker"></i> <?= htmlspecialchars($je['address']) ?></p><p><i class="fa fa-phone"></i> <a href="tel:<?= htmlspecialchars($je['phone']) ?>"><?= htmlspecialchars($je['phone_display']) ?></a></p><p><i class="fa fa-envelope"></i> <a href="mailto:<?= htmlspecialchars($je['email']) ?>"><?= htmlspecialchars($je['email']) ?></a></p></div>
    </div>
    <div class="footer-bottom"><span>© <?= date('Y') ?> Jaipur Engineers. All rights reserved.</span><span>Java Full Stack Developer Course • Jaipur</span></div>
  </div>
</footer>
<div class="mobile-sticky"><a class="btn btn-dark" href="tel:<?= htmlspecialchars($je['phone']) ?>"><i class="fa fa-phone"></i> Call</a><a class="btn btn-primary" href="<?= htmlspecialchars(je_whatsapp_url('Hello Jaipur Engineers, I need Java Full Stack batch details.')) ?>" target="_blank" rel="noopener"><i class="fa fa-whatsapp"></i> WhatsApp</a></div>
<script src="assets/js/landing.js"></script>
</body>
</html>
