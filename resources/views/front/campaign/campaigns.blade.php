<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Waste2Product - Campaigns</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8fff8;
    margin: 0;
    overflow-x: hidden;
}

/* Hero Section */
.hero-campaign {
    height: 70vh;
    background: url("{{ asset('images/EarthFront.png') }}") no-repeat center center/cover;
    position: relative;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}
.hero-campaign::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(2,40,22,0.8), rgba(0,0,0,0.6));
    z-index: 1;
}
.hero-campaign .content {
    position: relative;
    z-index: 2;
    max-width: 800px;
}
.hero-campaign h1 {
    font-size: 4rem;
    font-weight: 800;
    color: #a7f3d0;
    text-shadow: 0 4px 8px rgba(0,0,0,0.4);
    margin-bottom: 20px;
}
.hero-campaign p {
    font-size: 1.5rem;
    font-weight: 300;
    margin-bottom: 30px;
}

/* Campaign Cards */
.campaign-card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 6px 25px rgba(0,128,0,0.15);
    transition: transform 0.4s ease, box-shadow 0.4s ease, border 0.3s ease;
    background: white;
    position: relative;
}
.campaign-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 12px 40px rgba(0,128,0,0.25);
    border: 1px solid #198754;
}
.campaign-card img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.campaign-card:hover img {
    transform: scale(1.05);
}
.card-body { padding: 20px; }
.card-body h5 { color: #198754; font-weight: 700; font-size: 1.4rem; margin-bottom: 10px; }
.card-body p { color: #6c757d; font-size: 1rem; margin-bottom: 15px; }
.campaign-dates { font-size: 0.9rem; color: #6c757d; margin-bottom: 15px; }
.campaign-status { position: absolute; top: 15px; right: 15px; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase; }
.status-active { background-color: #d4edda; color: #198754; }
.status-ended { background-color: #f8d7da; color: #721c24; }
.btn-success { border-radius: 50px; padding: 10px 25px; font-weight: 600; transition: background-color 0.3s ease, transform 0.3s ease; }
.btn-success:hover { background-color: #146c43; transform: scale(1.05); }

/* Filter Section */
.filter-section {
    background: #e6f4ea;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 40px;
    box-shadow: 0 4px 15px rgba(0,128,0,0.1);
}
.filter-section .btn { margin-right: 10px; border-radius: 30px; }

/* Footer */
footer {
    background-color: #198754;
    color: white;
    text-align: center;
    padding: 20px 0;
    font-size: 1rem;
    margin-top: 60px;
    box-shadow: 0 -4px 10px rgba(0,0,0,0.1);
}
.image-error { background-color: #f8d7da; color: #721c24; text-align: center; height: 250px; display: flex; align-items: center; justify-content: center; font-size: 1rem; }

/* Navbar */
.navbar { background-color: transparent !important; transition: background-color 0.4s ease; position: fixed; width: 100%; top: 0; z-index: 1000; }
.navbar.scrolled { background-color: #198754 !important; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
.navbar-brand { font-weight: bold; color: #fff !important; }
.nav-link { color: #fff !important; transition: color 0.3s ease; }
.nav-link:hover { color: #a7f3d0 !important; text-decoration: underline; }

/* Modal */
#campaignModal .list-group-item { border: none; padding: 0.75rem 0; }
#campaignModal .btn-success { border-radius: 50px; padding: 10px 25px; font-weight: 600; }
#campaignModalImage { object-fit: cover; height: 100%; width: 100%; }
@media(max-width:768px){
    #campaignModal .row { flex-direction: column; }
    #campaignModalImage { height: 250px; width: 100%; }
}

/* Responsive */
@media (max-width: 768px){
    .hero-campaign h1 { font-size: 2.8rem; }
    .hero-campaign p { font-size: 1.2rem; }
    .campaign-card img { height: 200px; }
    .filter-section { text-align: center; }
}
</style>
</head>
<body>
@extends('front.navbar')

<!-- Hero -->
<section class="hero-campaign">
    <div class="content">
        <h1>Join Environmental Campaigns</h1>
        <p>Be part of community-led initiatives turning waste into hope for a sustainable future.</p>
        <a href="#campaign-list" class="btn btn-success btn-lg">Explore Now</a>
    </div>
</section>

<!-- Campaign List -->
<main class="container py-5">
    <!-- Filter Section -->
    <section class="filter-section mb-5">
        <h4 class="text-center text-success fw-bold mb-4">Filter Campaigns</h4>
        <div class="d-flex justify-content-center flex-wrap">
            <button class="btn btn-outline-success active" data-filter="all">All</button>
            <button class="btn btn-outline-success" data-filter="clean_city">Clean City</button>
            <button class="btn btn-outline-success" data-filter="tree_planting">Tree Planting</button>
            <button class="btn btn-outline-success" data-filter="recycling_awareness">Recycling Awareness</button>
        </div>
    </section>

    <h2 class="text-center fw-bold text-success mb-5">Our Sensitization Campaigns</h2>
    <div class="row g-4" id="campaign-list"></div>
</main>

<!-- Campaign Modal -->
<div class="modal fade" id="campaignModal" tabindex="-1" aria-labelledby="campaignModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content border-0">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="campaignModalLabel">Campaign Title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="row g-0">
          <!-- Left: Details -->
          <div class="col-md-6 p-4">
            <p id="campaignModalDescription" class="text-muted"></p>
            <ul class="list-group list-group-flush mb-3">
              <li class="list-group-item"><strong>Type:</strong> <span id="campaignModalType"></span></li>
              <li class="list-group-item"><strong>City:</strong> <span id="campaignModalCity"></span></li>
              <li class="list-group-item"><strong>Region:</strong> <span id="campaignModalRegion"></span></li>
              <li class="list-group-item"><strong>Participants:</strong> <span id="campaignModalParticipants"></span></li>
              <li class="list-group-item"><strong>Registration Deadline:</strong> <span id="campaignModalDeadline"></span></li>
              <li class="list-group-item"><strong>Campaign Dates:</strong> <span id="campaignModalDates"></span></li>
            </ul>
            <a href="#" class="btn btn-success" id="campaignModalBtn"><i class="bi bi-person-plus me-2"></i>Participate</a>
          </div>
          <!-- Right: Image -->
          <div class="col-md-6">
            <img src="" id="campaignModalImage" class="img-fluid h-100 w-100 object-fit-cover rounded-end" alt="Campaign Image">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer>
    © {{ date('Y') }} Waste2Product — Together for a Cleaner Future 🌱
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('scroll', function () {
    const navbar = document.querySelector('.navbar');
    navbar.classList.toggle('scrolled', window.scrollY > 50);
});

$(document).ready(function () {
    // Fetch campaigns from backend
    $.ajax({
        url: '{{ url("campaigns") }}',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            const campaignList = $('#campaign-list');
            campaignList.empty();

            const campaignConfig = {
                'clean_city': { icon: 'bi-person-plus', buttonText: 'Participate', color: '#198754' },
                'tree_planting': { icon: 'bi-tree', buttonText: 'Join Now', color: '#28a745' },
                'recycling_awareness': { icon: 'bi-recycle', buttonText: 'Support', color: '#146c43' }
            };
            const defaultConfig = { icon: 'bi-hand-thumbs-up', buttonText: 'Get Involved', color: '#198754' };

            data.forEach(campaign => {
                const imageSrc = campaign.image || '{{ asset("images/default-campaign.jpg") }}';
                const config = campaignConfig[campaign.type] || defaultConfig;
                const statusClass = campaign.status === 'active' ? 'status-active' : 'status-ended';
                const statusText = campaign.status ? campaign.status.toUpperCase() : 'UNKNOWN';

                const cardHtml = `
                <div class="col-md-4 campaign-item" data-type="${campaign.type || 'other'}">
                    <div class="campaign-card">
                        <img src="${imageSrc}" alt="${campaign.title}" onerror="this.outerHTML='<div class=\\'image-error\\'>Image not found</div>'">
                        <span class="campaign-status ${statusClass}">${statusText}</span>
                        <div class="card-body">
                            <h5><i class="bi ${config.icon} me-2" style="color:${config.color}"></i>${campaign.title}</h5>
                            <p class="text-muted">${campaign.description || 'No description available'}</p>
                            <div class="campaign-dates"><i class="bi bi-calendar-event me-2"></i>${campaign.start_date || 'N/A'} - ${campaign.end_date || 'N/A'}</div>
                            <a href="#" class="btn btn-outline-success btn-sm see-more-btn" 
                                data-bs-toggle="modal" data-bs-target="#campaignModal"
                                data-title="${campaign.title}"
                                data-description="${campaign.description}"
                                data-image="${imageSrc}"
                                data-type="${campaign.type}"
                                data-city="${campaign.city || 'N/A'}"
                                data-region="${campaign.region || 'N/A'}"
                                data-participants="${campaign.participants_count || 0}"
                                data-deadline="${campaign.deadline_registration || 'N/A'}"
                                data-dates="${campaign.start_date || 'N/A'} - ${campaign.end_date || 'N/A'}"
                                data-id="${campaign.id}"> See More </a>
                        </div>
                    </div>
                </div>`;
                campaignList.append(cardHtml);
            });
        },
        error: function() {
            $('#campaign-list').html('<p class="text-danger text-center">Failed to load campaigns. Please try again later.</p>');
        }
    });

    // Filter functionality
    $('.filter-section .btn').on('click', function() {
        $('.filter-section .btn').removeClass('active');
        $(this).addClass('active');
        const filter = $(this).data('filter');
        if (filter === 'all') {
            $('.campaign-item').fadeIn(300);
        } else {
            $('.campaign-item').fadeOut(300);
            $(`.campaign-item[data-type="${filter}"]`).fadeIn(300);
        }
    });

    // Fill modal dynamically
    $(document).on('click', '.see-more-btn', function() {
        const btn = $(this);
        $('#campaignModalLabel').text(btn.data('title'));
        $('#campaignModalDescription').text(btn.data('description'));
        $('#campaignModalImage').attr('src', btn.data('image'));
        $('#campaignModalType').text(btn.data('type'));
        $('#campaignModalCity').text(btn.data('city'));
        $('#campaignModalRegion').text(btn.data('region'));
        $('#campaignModalParticipants').text(btn.data('participants'));
        $('#campaignModalDeadline').text(btn.data('deadline'));
        $('#campaignModalDates').text(btn.data('dates'));
        $('#campaignModalBtn').attr('href', `/campaigns/${btn.data('id')}`);
    });
});
</script>
</body>
</html>
