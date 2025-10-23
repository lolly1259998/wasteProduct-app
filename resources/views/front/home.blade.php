@extends('front.layout')

@section('content')
<style>
    /* Section Hero plein écran avec image de fond */
    .hero {
        position: relative;
        height: 100vh;
        background: url("{{ asset('images/Earth Day Banner.png') }}") no-repeat center center/cover;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-align: center;
        overflow: hidden;
    }

    /* Overlay sombre pour lisibilité du texte */
    .hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
    }

    /* Texte centré au milieu */
    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 700px;
        padding: 20px;
    }

    .hero-content h1 {
        font-size: 3rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .hero-content h1 span {
        color: #a7f3d0;
        background: rgba(0, 0, 0, 0.2);
        padding: 5px 10px;
        border-radius: 8px;
    }

    .hero-content p {
        margin-top: 15px;
        font-size: 1.25rem;
        color: #e8f5e9;
    }

    .hero-content .btn {
        margin-top: 25px;
        padding: 12px 28px;
        font-weight: 600;
        border-radius: 8px;
    }

    .btn-success {
        background-color: #2d6a4f;
        border: none;
    }

    .btn-outline-light {
        border: 2px solid #fff;
        color: #fff;
        margin-left: 10px;
    }

    /* Cartes sous le hero */
    .features {
        padding: 50px 0;
    }

    .features .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s;
    }

    .features .card:hover {
        transform: translateY(-5px);
    }

    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2.2rem;
        }
        .hero-content p {
            font-size: 1.1rem;
        }
    }

    .recommended-campaigns .card {
  transition: transform 0.3s ease;
}
.recommended-campaigns .card:hover {
  transform: translateY(-6px);
}
.recommended-campaigns h5 {
  font-size: 1.1rem;
}

</style>



<!-- Section Features -->
<section class="features">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card h-100 p-4">
                    <i class="bi bi-recycle text-success display-5 mb-3"></i>
                    <h5 class="fw-bold text-success">Recycling</h5>
                    <p class="text-muted">Give waste a new life through smart, sustainable recycling methods.</p>
                         <a href="{{ url('/register') }}" class="btn btn-success">Join Now</a>

                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100 p-4">
                    <i class="bi bi-bag-heart text-success display-5 mb-3"></i>
                    <h5 class="fw-bold text-success">Eco Products</h5>
                    <p class="text-muted">Discover beautiful, useful, and affordable recycled products.</p>
                         <a href="{{ url('/register') }}" class="btn btn-success">Join Now</a>

                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card h-100 p-4">
                    <i class="bi bi-people text-success display-5 mb-3"></i>
                    <h5 class="fw-bold text-success">Community</h5>
                    <p class="text-muted">Join a movement of citizens and businesses working for a green world.</p>
                         <a href="{{ url('/campaignsFront') }}" class="btn btn-success">Join Now</a>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- 🌍 Recommended Campaigns (AI Section) -->
<section class="recommended-campaigns py-5" style="background:#f8fff9;">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold text-success">
        <i class="bi bi-stars me-2"></i>Recommended Campaigns Near You
      </h2>
      <p class="text-muted">AI-selected campaigns based on your location and interests.</p>
    </div>

    <div id="ai-recommendations" class="row g-4 justify-content-center">
      <!-- Les campagnes seront injectées ici -->
    </div>

    <div id="ai-loader" class="text-center text-muted mt-4">
      <i class="bi bi-hourglass-split"></i> Loading AI recommendations...
    </div>
  </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('ai-recommendations');
  const loader = document.getElementById('ai-loader');

  fetch('/ai/recommendations')
    .then(res => res.json())
    .then(data => {
      loader.style.display = 'none';
      if (!data.recommendations || data.recommendations.length === 0) {
        container.innerHTML = `<p class="text-muted text-center">No recommendations available for your location yet.</p>`;
        return;
      }

      data.recommendations.forEach(c => {
        container.innerHTML += `
          <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
              <img 
  src="${c.image}" 
  onerror="this.src='/images/default-campaign.png'" 
  class="card-img-top rounded-top-4" 
  style="height:220px; object-fit:cover;">

              <div class="card-body">
                <h5 class="fw-bold text-success">${c.title}</h5>
                <p class="text-muted small mb-2"><i class="bi bi-geo-alt"></i> ${c.city ?? ''} - ${c.region ?? ''}</p>
                <p class="small text-dark">${(c.similarity * 100).toFixed(1)}% match with your interests</p>
                <a href="/campaignsFront" class="btn btn-outline-success btn-sm rounded-pill mt-2">
                  <i class="bi bi-megaphone"></i> View Campaign
                </a>
              </div>
            </div>
          </div>
        `;
      });
      console.log("Campagnes envoyées à Flask :", campaigns);

    })
    .catch(err => {
      loader.innerHTML = `<p class="text-danger">AI service unreachable. Please try again later.</p>`;
      console.error('AI error:', err);
    });
});
</script>

@endsection
