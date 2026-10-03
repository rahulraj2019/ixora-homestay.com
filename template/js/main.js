(function () {
  const toggle = document.querySelector(".nav-toggle");
  const nav = document.querySelector(".nav");
  if (toggle && nav) {
    toggle.addEventListener("click", function () {
      const open = nav.classList.toggle("open");
      toggle.setAttribute("aria-expanded", open ? "true" : "false");
    });
    nav.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        nav.classList.remove("open");
        toggle.setAttribute("aria-expanded", "false");
      });
    });
  }

  document.querySelectorAll("[data-step]").forEach(function (wrap) {
    const out = wrap.querySelector("[data-count]");
    const form = wrap.closest("form");
    const hidden = wrap.getAttribute("data-target")
      ? document.querySelector(wrap.getAttribute("data-target"))
      : (form ? form.elements.guests : null);
    wrap.querySelectorAll("button").forEach(function (btn) {
      btn.addEventListener("click", function () {
        let n = parseInt(out.textContent, 10) || 1;
        n += btn.dataset.step === "plus" ? 1 : -1;
        n = Math.max(1, Math.min(30, n));
        out.textContent = n;
        if (hidden) hidden.value = n;
      });
    });
  });

  document.querySelectorAll(".filters").forEach(function (bar) {
    const scope = document.querySelector(bar.getAttribute("data-scope"));
    if (!scope) return;
    bar.querySelectorAll("button").forEach(function (btn) {
      btn.addEventListener("click", function () {
        bar.querySelectorAll("button").forEach(function (b) { b.classList.remove("on"); });
        btn.classList.add("on");
        const filter = btn.dataset.filter;
        scope.querySelectorAll("[data-cat]").forEach(function (item) {
          const cats = item.dataset.cat.split(" ");
          item.hidden = filter !== "all" && cats.indexOf(filter) === -1;
        });
      });
    });
  });

  const box = document.querySelector(".lightbox");
  if (box) {
    const img = box.querySelector("img");
    document.querySelectorAll("[data-zoom]").forEach(function (el) {
      el.addEventListener("click", function () {
        const src = el.getAttribute("data-zoom") || el.querySelector("img").src;
        img.src = src;
        img.alt = el.getAttribute("data-caption") || "";
        box.classList.add("open");
      });
    });
    box.addEventListener("click", function (e) {
      if (e.target === box || e.target.closest("button")) box.classList.remove("open");
    });
  }

  const form = document.querySelector("#booking-form");
  if (form) {
    const params = new URLSearchParams(location.search);
    ["checkin", "checkout"].forEach(function (key) {
      if (params.get(key) && form.elements[key]) form.elements[key].value = params.get(key);
    });
    const typeMap = {
      homestay: "Homestay",
      birthday: "Birthday Party",
      engagement: "Engagement",
      family: "Family Gathering",
      friends: "Friends Get-together",
      custom: "Custom Event"
    };
    if (params.get("type") && form.elements.type) {
      form.elements.type.value = typeMap[params.get("type")] || params.get("type");
    }
    if (params.get("guests")) {
      const n = Math.max(1, parseInt(params.get("guests"), 10) || 2);
      const count = form.querySelector("[data-count]");
      if (count) count.textContent = n;
      if (form.elements.guests) form.elements.guests.value = n;
    }
    if (params.get("addon")) {
      const note = form.elements.message;
      if (note && !note.value) note.value = "Please include: " + params.get("addon");
    }

    form.addEventListener("submit", function (e) {
      e.preventDefault();
      const data = new FormData(form);
      const lines = [
        "Hello, I would like to book IXORA — Niduvaloor Gate Homestay & Event Venue.",
        "Name: " + (data.get("name") || ""),
        "Phone: " + (data.get("phone") || ""),
        "Check-in: " + (data.get("checkin") || "not set"),
        "Check-out: " + (data.get("checkout") || "not set"),
        "Guests: " + (data.get("guests") || "2"),
        "Booking type: " + (data.get("type") || "homestay"),
        data.get("message") ? "Notes: " + data.get("message") : ""
      ].filter(Boolean);
      const url = "https://wa.me/918075771824?text=" + encodeURIComponent(lines.join("\n"));
      window.open(url, "_blank", "noopener");
    });
  }

  document.querySelectorAll("[data-search]").forEach(function (formEl) {
    formEl.addEventListener("submit", function (e) {
      e.preventDefault();
      const data = new FormData(formEl);
      const q = new URLSearchParams();
      ["checkin", "checkout", "guests", "type"].forEach(function (key) {
        if (data.get(key)) q.set(key, data.get(key));
      });
      location.href = "booking.html?" + q.toString();
    });
  });

  /* Guest reviews */
  (function initReviews() {
    const list = document.querySelector("[data-reviews-list]");
    const form = document.querySelector("#review-form");
    if (!list && !form) return;

    const apiUrl = "api/reviews.php";
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
      if (!reviews.length) {
        list.innerHTML = '<p class="muted reviews-empty">Be the first to share your experience at IXORA.</p>';
        return;
      }
      list.innerHTML = reviews.map(function (r) {
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

        fetch(apiUrl, {
          method: "POST",
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json"
          },
          body: JSON.stringify(payload)
        })
          .then(function (res) {
            return res.json().then(function (body) {
              return { ok: res.ok, body: body };
            });
          })
          .then(function (result) {
            if (!result.body || !result.body.ok) {
              throw new Error((result.body && result.body.error) || "Something went wrong.");
            }
            form.reset();
            const five = form.querySelector('input[name="rating"][value="5"]');
            if (five) five.checked = true;
            setStatus(result.body.message || "Thank you for your review!", "ok");
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

    loadReviews();
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
})();
