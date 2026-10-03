<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Admin Login — IXORA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #f4f1ea;
            --muted: rgba(244, 241, 234, 0.72);
            --panel: rgba(255, 255, 255, 0.96);
            --text: #14261d;
            --soft: #5a6b61;
            --accent: #1f4d38;
            --gold: #e8d3a4;
            --err: #b71c1c;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Outfit", system-ui, sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 15% 20%, rgba(232, 211, 164, 0.18), transparent 28%),
                radial-gradient(circle at 85% 80%, rgba(47, 93, 69, 0.35), transparent 32%),
                linear-gradient(155deg, #0d1f17 0%, #163528 48%, #1c3f2d 100%);
            overflow: hidden;
        }

        .login-stage {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 1.5rem;
            position: relative;
        }

        .bg-leaf {
            position: absolute;
            width: min(42vw, 420px);
            opacity: 0.14;
            pointer-events: none;
            filter: blur(0.2px);
        }

        .bg-leaf--left { left: -4%; bottom: -6%; transform: rotate(-12deg); }
        .bg-leaf--right { right: -5%; top: -8%; transform: rotate(18deg) scaleX(-1); }

        .login-shell {
            width: min(920px, 100%);
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 0;
            position: relative;
            z-index: 2;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.35);
            background: rgba(10, 24, 18, 0.55);
            border: 1px solid rgba(232, 211, 164, 0.18);
            backdrop-filter: blur(10px);
        }

        .login-brand {
            padding: clamp(1.6rem, 4vw, 2.6rem);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 520px;
            background:
                linear-gradient(160deg, rgba(20, 48, 35, 0.2), rgba(8, 18, 14, 0.55)),
                url("<?php echo e(asset('assets/images/ixora-homestay-niduvaloor-exterior-sunset.jpg')); ?>") center/cover;
            color: #fff;
            position: relative;
        }

        .login-brand::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(8, 20, 15, 0.35), rgba(8, 20, 15, 0.72));
            pointer-events: none;
        }

        .login-brand > * { position: relative; z-index: 1; }

        .brand-mark {
            display: inline-flex;
            align-items: center;
            gap: .75rem;
        }

        .brand-mark span {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: var(--gold);
            color: #163528;
            font-weight: 700;
            font-family: "Cormorant Garamond", serif;
            font-size: 1.35rem;
        }

        .brand-mark strong {
            display: block;
            font-family: "Cormorant Garamond", serif;
            font-size: 1.45rem;
            letter-spacing: 0.08em;
        }

        .brand-mark small {
            display: block;
            color: rgba(255, 255, 255, 0.75);
            font-size: .78rem;
        }

        .brand-copy h1 {
            margin: 0 0 .6rem;
            font-family: "Cormorant Garamond", serif;
            font-size: clamp(2.2rem, 4vw, 3.1rem);
            line-height: 1.05;
            font-weight: 600;
        }

        .brand-copy p {
            margin: 0;
            max-width: 22rem;
            color: rgba(255, 255, 255, 0.82);
            line-height: 1.55;
        }

        .brand-foot {
            display: flex;
            gap: .6rem;
            flex-wrap: wrap;
        }

        .brand-foot span {
            padding: .35rem .7rem;
            border-radius: 999px;
            border: 1px solid rgba(232, 211, 164, 0.35);
            background: rgba(0, 0, 0, 0.2);
            font-size: .75rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .login-panel {
            background: var(--panel);
            color: var(--text);
            padding: clamp(1.6rem, 4vw, 2.5rem);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-panel h2 {
            margin: 0 0 .35rem;
            font-family: "Cormorant Garamond", serif;
            font-size: 2rem;
            font-weight: 600;
        }

        .login-panel .lead {
            margin: 0 0 1.4rem;
            color: var(--soft);
            line-height: 1.5;
        }

        .field { margin-bottom: 1rem; }

        label {
            display: block;
            margin-bottom: .35rem;
            font-size: .82rem;
            color: var(--soft);
            font-weight: 500;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: .85rem 1rem;
            border: 1px solid #d7ddd8;
            border-radius: 12px;
            background: #f7f9f7;
            font: inherit;
            color: var(--text);
            transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
        }

        input:focus {
            outline: none;
            border-color: #7fa38f;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(31, 77, 56, 0.12);
        }

        .row-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin: .2rem 0 1.2rem;
            font-size: .9rem;
            color: var(--soft);
        }

        .row-between label {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            margin: 0;
            cursor: pointer;
        }

        .btn-enter {
            width: 100%;
            border: 0;
            border-radius: 14px;
            padding: .95rem 1.1rem;
            background: linear-gradient(135deg, #1f4d38, #2f6a4d);
            color: #fff;
            font: inherit;
            font-weight: 600;
            letter-spacing: 0.02em;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .55rem;
            box-shadow: 0 14px 28px rgba(31, 77, 56, 0.28);
            transition: transform .15s ease, filter .15s ease;
        }

        .btn-enter:hover { filter: brightness(1.05); transform: translateY(-1px); }
        .btn-enter:disabled { opacity: .7; cursor: wait; transform: none; }

        .alert {
            padding: .75rem .9rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            font-size: .9rem;
        }

        .alert.err {
            background: #fdecea;
            color: var(--err);
        }

        .login-footnote {
            margin-top: 1.2rem;
            text-align: center;
            color: var(--soft);
            font-size: .82rem;
        }

        .login-footnote a { color: var(--accent); font-weight: 600; }

        /* Door ceremony */
        .door-overlay {
            position: fixed;
            inset: 0;
            z-index: 50;
            pointer-events: none;
            opacity: 0;
            visibility: hidden;
        }

        .door-overlay.is-active {
            pointer-events: auto;
            opacity: 1;
            visibility: visible;
        }

        .door-glow {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at center, rgba(232, 211, 164, 0.55), transparent 42%),
                linear-gradient(180deg, #214836, #0d1f17);
            opacity: 0;
            transition: opacity .5s ease;
        }

        .door-frame {
            position: absolute;
            inset: 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            perspective: 1600px;
        }

        .door {
            position: relative;
            background:
                linear-gradient(90deg, rgba(0, 0, 0, 0.18), transparent 18%),
                linear-gradient(180deg, #1a3729 0%, #12261c 100%);
            border: 0;
            transform-origin: left center;
            transform: translateZ(0);
            box-shadow: inset -20px 0 40px rgba(0, 0, 0, 0.25);
            transition: transform 1.35s cubic-bezier(.22, .8, .24, 1);
        }

        .door--right {
            transform-origin: right center;
            box-shadow: inset 20px 0 40px rgba(0, 0, 0, 0.25);
            background:
                linear-gradient(270deg, rgba(0, 0, 0, 0.18), transparent 18%),
                linear-gradient(180deg, #1a3729 0%, #12261c 100%);
        }

        .door::before {
            content: "";
            position: absolute;
            inset: 8% 14%;
            border: 1px solid rgba(232, 211, 164, 0.28);
            border-radius: 8px;
            box-shadow: inset 0 0 0 10px rgba(255, 255, 255, 0.03);
        }

        .door::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: var(--gold);
            box-shadow: 0 0 0 4px rgba(232, 211, 164, 0.2);
            transform: translateY(-50%);
        }

        .door--left::after { right: 1.1rem; }
        .door--right::after { left: 1.1rem; }

        .door-message {
            position: absolute;
            inset: 0;
            display: grid;
            place-items: center;
            text-align: center;
            opacity: 0;
            transform: translateY(12px) scale(.98);
            transition: opacity .45s ease .35s, transform .45s ease .35s;
            z-index: 2;
            padding: 1.5rem;
        }

        .door-message strong {
            display: block;
            font-family: "Cormorant Garamond", serif;
            font-size: clamp(2rem, 5vw, 3.2rem);
            font-weight: 600;
            color: #fff;
            margin-bottom: .35rem;
        }

        .door-message span {
            color: rgba(255, 255, 255, 0.8);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-size: .8rem;
        }

        .door-overlay.is-opening .door-glow { opacity: 1; }
        .door-overlay.is-opening .door--left { transform: rotateY(-92deg); }
        .door-overlay.is-opening .door--right { transform: rotateY(92deg); }
        .door-overlay.is-opening .door-message {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .login-shell.is-leaving {
            opacity: 0;
            transform: scale(.96);
            transition: opacity .35s ease, transform .35s ease;
        }

        @media (max-width: 820px) {
            body { overflow: auto; }
            .login-shell { grid-template-columns: 1fr; }
            .login-brand { min-height: 240px; }
            .brand-copy h1 { font-size: 2rem; }
            .bg-leaf { display: none; }
        }

        @media (prefers-reduced-motion: reduce) {
            .door,
            .door-glow,
            .door-message,
            .login-shell {
                transition: none !important;
            }
        }
    </style>
</head>
<body>
<div class="login-stage" id="login-stage">
    <svg class="bg-leaf bg-leaf--left" viewBox="0 0 240 280" aria-hidden="true"><path fill="#e8d3a4" d="M20 260c40-80 30-150 70-200 20 50 10 110-10 160 40-30 90-80 130-70-50 30-90 70-120 110-20-10-46-8-70 0z"/></svg>
    <svg class="bg-leaf bg-leaf--right" viewBox="0 0 260 240" aria-hidden="true"><path fill="#e8d3a4" d="M250 20c-70 20-130 70-170 130 50-10 110 0 160 30-40-50-40-110 10-160z"/></svg>

    <div class="login-shell" id="login-shell">
        <section class="login-brand" aria-hidden="true">
            <div class="brand-mark">
                <span>I</span>
                <div>
                    <strong>IXORA</strong>
                    <small>Homestay & Event Venue</small>
                </div>
            </div>
            <div class="brand-copy">
                <h1>Open the door to your sanctuary.</h1>
                <p>Sign in to manage bookings, pages, media, and guest stories for Niduvaloor.</p>
            </div>
            <div class="brand-foot">
                <span>Secure admin</span>
                <span>Kannur, Kerala</span>
            </div>
        </section>

        <section class="login-panel">
            <h2>Welcome back</h2>
            <p class="lead">Enter your credentials to unlock the admin dashboard.</p>

            <div class="alert err" id="login-error" hidden></div>
            <?php if($errors->any()): ?>
                <div class="alert err" id="server-error"><?php echo e($errors->first()); ?></div>
            <?php endif; ?>

            <form id="admin-login-form" method="POST" action="<?php echo e(route('admin.login.submit')); ?>" novalidate>
                <?php echo csrf_field(); ?>
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username" placeholder="admin@ixora.test">
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                </div>
                <div class="row-between">
                    <label><input type="checkbox" name="remember" value="1"> Remember me</label>
                </div>
                <button class="btn-enter" type="submit" id="login-submit">
                    <span>Enter dashboard</span>
                    <span aria-hidden="true">→</span>
                </button>
            </form>

            <p class="login-footnote">
                <a href="<?php echo e(route('home')); ?>">← Back to website</a>
            </p>
        </section>
    </div>
</div>

<div class="door-overlay" id="door-overlay" aria-hidden="true">
    <div class="door-glow"></div>
    <div class="door-message">
        <div>
            <strong id="door-greeting">Welcome</strong>
            <span>Opening admin dashboard</span>
        </div>
    </div>
    <div class="door-frame">
        <div class="door door--left"></div>
        <div class="door door--right"></div>
    </div>
</div>

<script>
(() => {
    const form = document.getElementById('admin-login-form');
    const shell = document.getElementById('login-shell');
    const overlay = document.getElementById('door-overlay');
    const errorBox = document.getElementById('login-error');
    const serverError = document.getElementById('server-error');
    const submitBtn = document.getElementById('login-submit');
    const greeting = document.getElementById('door-greeting');
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content
        || form?.querySelector('input[name="_token"]')?.value;

    if (!form) return;

    const showError = (message) => {
        if (serverError) serverError.hidden = true;
        errorBox.hidden = false;
        errorBox.textContent = message;
    };

    const openDoorThenGo = (url, name) => {
        if (name) greeting.textContent = `Welcome, ${name}`;
        shell.classList.add('is-leaving');
        overlay.classList.add('is-active');
        overlay.setAttribute('aria-hidden', 'false');

        requestAnimationFrame(() => {
            overlay.classList.add('is-opening');
        });

        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const delay = reduceMotion ? 150 : 1600;
        window.setTimeout(() => {
            window.location.href = url;
        }, delay);
    };

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        errorBox.hidden = true;
        submitBtn.disabled = true;
        submitBtn.querySelector('span').textContent = 'Checking…';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrf,
                },
                body: new FormData(form),
                credentials: 'same-origin',
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok) {
                let message = data.message
                    || data.errors?.email?.[0]
                    || data.errors?.password?.[0]
                    || 'Invalid credentials.';

                if (response.status === 419) {
                    message = 'Session expired. Refreshing…';
                    showError(message);
                    window.setTimeout(() => window.location.reload(), 700);
                    return;
                }

                showError(message);
                submitBtn.disabled = false;
                submitBtn.querySelector('span').textContent = 'Enter dashboard';
                return;
            }

            openDoorThenGo(data.redirect || <?php echo json_encode(route('admin.dashboard'), 15, 512) ?>, data.name || '');
        } catch (error) {
            showError('Something went wrong. Please try again.');
            submitBtn.disabled = false;
            submitBtn.querySelector('span').textContent = 'Enter dashboard';
        }
    });
})();
</script>
</body>
</html>
<?php /**PATH /home/u101508790/domains/ixora-homestay.com/public_html/resources/views/admin/auth/login.blade.php ENDPATH**/ ?>