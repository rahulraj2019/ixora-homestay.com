(function () {
  const toggle = document.querySelector(".nav-toggle");
  const nav = document.querySelector(".nav");
  const backdrop = document.querySelector(".nav-backdrop");

  function setNavOpen(open) {
    if (!toggle || !nav) return;
    nav.classList.toggle("open", open);
    toggle.setAttribute("aria-expanded", open ? "true" : "false");
    toggle.setAttribute("aria-label", open ? "Close menu" : "Open menu");
    document.body.classList.toggle("nav-is-open", open);
    if (backdrop) {
      backdrop.classList.toggle("is-open", open);
      backdrop.hidden = !open;
    }
  }

  if (toggle && nav) {
    toggle.addEventListener("click", function () {
      setNavOpen(!nav.classList.contains("open"));
    });
    nav.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        setNavOpen(false);
      });
    });
    if (backdrop) {
      backdrop.addEventListener("click", function () {
        setNavOpen(false);
      });
    }
    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape" && nav.classList.contains("open")) {
        setNavOpen(false);
        toggle.focus();
      }
    });
    window.addEventListener("resize", function () {
      if (window.matchMedia("(min-width: 861px)").matches && nav.classList.contains("open")) {
        setNavOpen(false);
      }
    });
  }

  document.querySelectorAll("[data-step]").forEach(function (wrap) {
    const out = wrap.querySelector("[data-count]");
    if (!out) return;
    const min = parseInt(wrap.getAttribute("data-min") || "1", 10);
    const max = parseInt(wrap.getAttribute("data-max") || "30", 10);
    const target = wrap.getAttribute("data-target");
    const form = wrap.closest("form");
    const hidden = target
      ? document.querySelector(target)
      : (form ? (form.elements.guest_count || form.elements.guests || null) : null);

    wrap.querySelectorAll("button").forEach(function (btn) {
      btn.addEventListener("click", function () {
        let n = parseInt(out.textContent, 10);
        if (isNaN(n)) n = min;
        n += btn.dataset.step === "plus" ? 1 : -1;
        n = Math.max(min, Math.min(max, n));
        out.textContent = n;
        if (hidden) hidden.value = n;
      });
    });
  });

  document.querySelectorAll(".filters").forEach(function (bar) {
    const scope = document.querySelector(bar.getAttribute("data-scope"));
    if (!scope) return;
    const empty = bar.parentElement
      ? bar.parentElement.querySelector("[data-filter-empty]")
      : null;

    bar.querySelectorAll("button[data-filter]").forEach(function (btn) {
      btn.addEventListener("click", function () {
        bar.querySelectorAll("button[data-filter]").forEach(function (b) {
          b.classList.remove("on");
          b.setAttribute("aria-selected", "false");
        });
        btn.classList.add("on");
        btn.setAttribute("aria-selected", "true");

        const filter = (btn.dataset.filter || "all").trim();
        let visible = 0;

        scope.querySelectorAll("[data-cat]").forEach(function (item) {
          const cats = (item.getAttribute("data-cat") || "").trim().split(/\s+/).filter(Boolean);
          const show = filter === "all" || cats.indexOf(filter) !== -1;
          item.hidden = !show;
          item.classList.toggle("is-filtered-out", !show);
          if (show) visible += 1;
        });

        if (empty) {
          empty.hidden = visible > 0;
        }
      });
    });
  });

  const box = document.querySelector(".lightbox");
  if (box) {
    const img = box.querySelector("img");
    const video = box.querySelector(".lightbox-video");

    function closeLightbox() {
      box.classList.remove("open", "lightbox--video", "lightbox--image");
      box.hidden = true;
      if (video) {
        video.pause();
        video.removeAttribute("src");
        video.removeAttribute("poster");
        video.load();
        video.hidden = true;
      }
      if (img) {
        img.removeAttribute("src");
        img.hidden = true;
      }
    }

    function openImage(src, alt) {
      if (video) {
        video.pause();
        video.removeAttribute("src");
        video.removeAttribute("poster");
        video.hidden = true;
      }
      if (img) {
        img.hidden = false;
        img.src = src;
        img.alt = alt || "";
      }
      box.classList.remove("lightbox--video");
      box.classList.add("lightbox--image");
      box.hidden = false;
      box.classList.add("open");
    }

    function openVideo(src, poster, title) {
      if (img) {
        img.hidden = true;
        img.removeAttribute("src");
      }
      if (video) {
        video.hidden = false;
        if (poster) {
          video.setAttribute("poster", poster);
        } else {
          video.removeAttribute("poster");
        }
        video.setAttribute("src", src);
        video.load();
        const playAttempt = video.play();
        if (playAttempt && typeof playAttempt.catch === "function") {
          playAttempt.catch(function () {});
        }
      }
      box.classList.remove("lightbox--image");
      box.classList.add("lightbox--video");
      box.hidden = false;
      box.classList.add("open");
      box.setAttribute("aria-label", title || "Video");
    }

    document.querySelectorAll("[data-zoom]").forEach(function (el) {
      el.addEventListener("click", function () {
        const src = el.getAttribute("data-zoom") || el.querySelector("img").src;
        openImage(src, el.getAttribute("data-caption") || "");
      });
    });

    document.querySelectorAll("[data-video-open]").forEach(function (el) {
      el.addEventListener("click", function () {
        const src = el.getAttribute("data-video-src");
        if (!src) return;
        openVideo(
          src,
          el.getAttribute("data-video-poster") || "",
          el.getAttribute("data-video-title") || "Property tour"
        );
      });
    });

    box.addEventListener("click", function (e) {
      if (e.target === box || e.target.closest("button")) closeLightbox();
    });

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape" && box.classList.contains("open")) {
        closeLightbox();
      }
    });
  }

  const form = document.querySelector("#booking-form");
  if (form) {
    const params = new URLSearchParams(location.search);
    const checkInEl = form.elements.check_in || form.elements.checkin;
    const checkOutEl = form.elements.check_out || form.elements.checkout;
    if (params.get("checkin") && checkInEl) checkInEl.value = params.get("checkin");
    if (params.get("checkout") && checkOutEl) checkOutEl.value = params.get("checkout");
    const typeMap = {
      homestay: "Homestay",
      birthday: "Birthday Party",
      engagement: "Engagement",
      family: "Family Gathering",
      friends: "Friends Get-together",
      custom: "Custom Event"
    };
    const typeEl = form.elements.booking_type || form.elements.type;
    if (params.get("type") && typeEl) {
      typeEl.value = typeMap[params.get("type")] || params.get("type");
    }
    if (params.get("adults") || params.get("guests")) {
      const adults = Math.max(1, parseInt(params.get("adults") || params.get("guests"), 10) || 2);
      const adultsEl = form.elements.adults;
      const adultsCount = form.querySelector('[data-target="#adults"] [data-count]');
      if (adultsEl) adultsEl.value = adults;
      if (adultsCount) adultsCount.textContent = adults;
    }
    if (params.get("children")) {
      const kids = Math.max(0, parseInt(params.get("children"), 10) || 0);
      const kidsEl = form.elements.children;
      const kidsCount = form.querySelector('[data-target="#children"] [data-count]');
      if (kidsEl) kidsEl.value = kids;
      if (kidsCount) kidsCount.textContent = kids;
    }
    if (params.get("addon")) {
      const note = form.elements.message;
      if (note && !note.value) note.value = "Please include: " + params.get("addon");
    }
    // Native POST to Laravel — do not intercept
  }

  document.querySelectorAll("[data-search]").forEach(function (formEl) {
    formEl.addEventListener("submit", function (e) {
      e.preventDefault();
      const data = new FormData(formEl);
      const q = new URLSearchParams();
      ["checkin", "checkout", "adults", "children", "type"].forEach(function (key) {
        if (data.get(key) !== null && data.get(key) !== "") q.set(key, data.get(key));
      });
      const base = (window.IXORA && window.IXORA.routes && window.IXORA.routes.bookingPage) || "booking";
      location.href = base + (q.toString() ? ("?" + q.toString()) : "");
    });
  });

  /* Guest reviews */
  (function initReviews() {
    const list = document.querySelector("[data-reviews-list]");
    const form = document.querySelector("#review-form");
    if (!list && !form) return;

    const apiUrl = (window.IXORA && window.IXORA.routes && window.IXORA.routes.reviews) || "/api/reviews";
    const apiStore = (window.IXORA && window.IXORA.routes && window.IXORA.routes.reviewsStore) || apiUrl;
    const csrf = (window.IXORA && window.IXORA.csrf)
      || (document.querySelector('meta[name="csrf-token"]') && document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
      || "";
    const scoreEl = document.querySelector("[data-reviews-score]");
    const avgEl = document.querySelector("[data-avg]");
    const countLabel = document.querySelector("[data-count-label]");
    const statusEl = document.querySelector("[data-review-status]");

    function escapeHtml(str) {
      return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#39;");
    }

    function stars(n) {
      const rating = Math.max(1, Math.min(5, parseInt(n, 10) || 5));
      return "★".repeat(rating) + "☆".repeat(5 - rating);
    }

    function initial(name) {
      const t = String(name || "").trim();
      return t ? t.charAt(0).toUpperCase() : "G";
    }

    function renderReviews(reviews) {
      if (!list) return;
      const limitAttr = list.getAttribute("data-reviews-limit");
      const limit = limitAttr ? parseInt(limitAttr, 10) : 0;
      const items = limit > 0 ? reviews.slice(0, limit) : reviews;
      if (!items.length) {
        list.innerHTML = '<p class="muted reviews-empty">Be the first to share your experience at IXORA.</p>';
        return;
      }
      list.innerHTML = items.map(function (r) {
        return (
          '<article class="review-card">' +
            '<div class="stars" aria-label="' + escapeHtml(r.rating) + ' out of 5 stars">' + stars(r.rating) + "</div>" +
            "<p>" + escapeHtml(r.message) + "</p>" +
            '<div class="review-meta">' +
              '<div class="review-avatar" aria-hidden="true">' + escapeHtml(initial(r.name)) + "</div>" +
              "<div>" +
                "<strong>" + escapeHtml(r.name) + "</strong>" +
                "<span>" + escapeHtml(r.location) + "</span>" +
              "</div>" +
            "</div>" +
          "</article>"
        );
      }).join("");
    }

    function updateScore(average, count) {
      if (!scoreEl) return;
      if (!count) {
        scoreEl.hidden = true;
        return;
      }
      scoreEl.hidden = false;
      if (avgEl) avgEl.textContent = Number(average).toFixed(1);
      if (countLabel) {
        countLabel.textContent = count === 1 ? "from 1 guest review" : "from " + count + " guest reviews";
      }
    }

    function setStatus(msg, type) {
      if (!statusEl) return;
      statusEl.textContent = msg || "";
      statusEl.classList.remove("is-ok", "is-error");
      if (type) statusEl.classList.add(type === "ok" ? "is-ok" : "is-error");
    }

    function loadReviews() {
      return fetch(apiUrl, { headers: { Accept: "application/json" } })
        .then(function (res) { return res.json(); })
        .then(function (data) {
          if (!data || !data.ok) throw new Error("Could not load reviews");
          renderReviews(data.reviews || []);
          updateScore(data.average || 0, data.count || 0);
        })
        .catch(function () {
          if (list) {
            list.innerHTML = '<p class="muted reviews-empty">Reviews will appear here once available.</p>';
          }
        });
    }

    if (form) {
      form.addEventListener("submit", function (e) {
        e.preventDefault();
        setStatus("");
        const data = new FormData(form);
        const payload = {
          name: (data.get("name") || "").toString().trim(),
          email: (data.get("email") || "").toString().trim(),
          location: (data.get("location") || "").toString().trim(),
          message: (data.get("message") || "").toString().trim(),
          rating: parseInt(data.get("rating"), 10) || 5,
          website: (data.get("website") || "").toString().trim()
        };

        if (payload.name.length < 2) {
          setStatus("Please enter your name.", "error");
          return;
        }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(payload.email)) {
          setStatus("Please enter a valid email address.", "error");
          return;
        }
        if (payload.location.length < 2) {
          setStatus("Please enter your location.", "error");
          return;
        }
        if (payload.message.length < 10) {
          setStatus("Please write a slightly longer review (at least 10 characters).", "error");
          return;
        }

        const btn = form.querySelector('button[type="submit"]');
        if (btn) {
          btn.disabled = true;
          btn.textContent = "Sending…";
        }

        fetch(apiStore, {
          method: "POST",
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrf,
            "X-Requested-With": "XMLHttpRequest"
          },
          body: JSON.stringify(payload)
        })
          .then(function (res) {
            return res.json().then(function (body) {
              return { ok: res.ok, body: body };
            });
          })
          .then(function (result) {
            if (!result.ok || !result.body || !result.body.ok) {
              var msg = (result.body && result.body.message) || (result.body && result.body.error) || "Something went wrong.";
              if (result.body && result.body.errors) {
                msg = Object.values(result.body.errors)[0][0] || msg;
              }
              throw new Error(msg);
            }
            form.reset();
            const five = form.querySelector('input[name="rating"][value="5"]');
            if (five) five.checked = true;
            setStatus("");
            var wrap = document.querySelector("[data-review-form-wrap]");
            var success = document.querySelector("[data-review-success]");
            if (wrap && success) {
              wrap.hidden = true;
              success.hidden = false;
              success.innerHTML =
                '<div class="flash-card flash-success flash-success-dark">' +
                  '<div class="flash-icon" aria-hidden="true">✓</div>' +
                  '<div class="flash-body">' +
                    '<p class="flash-eyebrow">Review received</p>' +
                    '<h2 class="flash-title">Thank you for sharing</h2>' +
                    '<p class="flash-text">' + escapeHtml(result.body.message || "Your review was submitted and will appear after approval.") + "</p>" +
                    '<div class="flash-actions">' +
                      '<button type="button" class="btn btn-gold" data-review-again>Write another review</button>' +
                    "</div>" +
                  "</div>" +
                "</div>";
              var again = success.querySelector("[data-review-again]");
              if (again) {
                again.addEventListener("click", function () {
                  success.hidden = true;
                  success.innerHTML = "";
                  wrap.hidden = false;
                });
              }
            } else {
              setStatus(result.body.message || "Thank you for your review!", "ok");
            }
            return loadReviews();
          })
          .catch(function (err) {
            setStatus(err.message || "Could not submit your review. Please try again.", "error");
          })
          .finally(function () {
            if (btn) {
              btn.disabled = false;
              btn.textContent = "Submit review";
            }
          });
      });
    }

    // Prefer server-rendered reviews; only fetch when the list is empty
    // or after a successful form submission.
    const hasServerReviews = !!(list && list.querySelector(".review-card"));
    if (!hasServerReviews) {
      loadReviews();
    }
  })();

  /* FAQ accordion — one open at a time */
  document.querySelectorAll("[data-faq]").forEach(function (list) {
    list.querySelectorAll("details.faq-item").forEach(function (item) {
      item.addEventListener("toggle", function () {
        if (!item.open) return;
        list.querySelectorAll("details.faq-item").forEach(function (other) {
          if (other !== item) other.open = false;
        });
      });
    });
  });

  /* Click-to-load Google Maps (avoids third-party cost until needed) */
  document.querySelectorAll(".map-facade[data-map-src]").forEach(function (facade) {
    var activate = function () {
      var src = facade.getAttribute("data-map-src");
      if (!src) return;
      var title = facade.getAttribute("data-map-title") || "Google Map";
      var iframe = document.createElement("iframe");
      iframe.src = src;
      iframe.title = title;
      iframe.loading = "lazy";
      iframe.referrerPolicy = "no-referrer-when-downgrade";
      iframe.allowFullscreen = true;
      facade.replaceWith(iframe);
    };
    facade.addEventListener("click", activate, { once: true });
    facade.addEventListener("keydown", function (event) {
      if (event.key === "Enter" || event.key === " ") {
        event.preventDefault();
        activate();
      }
    });
  });

  /**
   * Open personal WhatsApp (com.whatsapp), not WhatsApp Business.
   * Android often routes wa.me to Business when both apps are installed.
   */
  function openPersonalWhatsApp(phone, text, fallbackUrl) {
    const cleanPhone = String(phone || "").replace(/\D+/g, "");
    const message = text || "";
    const encoded = encodeURIComponent(message);
    const webUrl =
      fallbackUrl ||
      ("https://api.whatsapp.com/send?phone=" + cleanPhone + "&text=" + encoded);
    const ua = navigator.userAgent || "";
    const isAndroid = /Android/i.test(ua);
    const isIOS = /iPhone|iPad|iPod/i.test(ua);

    if (!cleanPhone) {
      window.open(webUrl, "_blank", "noopener");
      return;
    }

    if (isAndroid) {
      const intent =
        "intent://send/?phone=" +
        cleanPhone +
        "&text=" +
        encoded +
        "#Intent;scheme=whatsapp;package=com.whatsapp;S.browser_fallback_url=" +
        encodeURIComponent(webUrl) +
        ";end";
      window.location.href = intent;
      return;
    }

    if (isIOS) {
      const appUrl = "whatsapp://send?phone=" + cleanPhone + "&text=" + encoded;
      const started = Date.now();
      window.location.href = appUrl;
      setTimeout(function () {
        if (Date.now() - started < 1600) {
          window.location.href = webUrl;
        }
      }, 1200);
      return;
    }

    window.open(webUrl, "_blank", "noopener");
  }

  document.addEventListener("click", function (event) {
    const link = event.target.closest("[data-whatsapp-chat], a[href*='api.whatsapp.com/send'], a[href*='wa.me/']");
    if (!link) return;

    const phone =
      link.getAttribute("data-whatsapp-phone") ||
      (window.IXORA && window.IXORA.whatsapp) ||
      "";
    const text =
      link.getAttribute("data-whatsapp-text") ||
      (window.IXORA && window.IXORA.whatsappMessage) ||
      "";
    const fallback = link.getAttribute("href") || (window.IXORA && window.IXORA.whatsappUrl) || "";

    if (!phone && !fallback) return;

    event.preventDefault();
    openPersonalWhatsApp(phone, text, fallback);
  });
})();
