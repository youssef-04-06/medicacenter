@extends('layouts.app')

@section('content')
<style>
    :root {
        --mc-blue-700: #0077b6;
        --mc-blue-800: #05557f;
        --mc-cyan-500: #00b4d8;
        --mc-slate-900: #102435;
        --mc-slate-700: #34546d;
        --mc-surface: #ffffff;
        --mc-surface-soft: rgba(255, 255, 255, 0.9);
        --mc-shadow: 0 24px 70px rgba(0, 84, 133, 0.14);
        --mc-shadow-lg: 0 30px 90px rgba(0, 64, 102, 0.18);
    }
    .services-hero {
        position: relative;
        overflow: hidden;
        background:
            radial-gradient(circle at 14% 14%, rgba(0, 180, 216, 0.18), transparent 32%),
            radial-gradient(circle at 84% 18%, rgba(0, 119, 182, 0.14), transparent 30%),
            linear-gradient(155deg, #edf7ff 0%, #f8fcff 54%, #e4f1fc 100%);
        padding: 72px 0 52px;
    }

    .services-hero .container {
        animation: heroFadeIn 0.8s ease both;
    }

    .services-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at 74% 20%, rgba(0, 180, 216, 0.12), transparent 30%),
            linear-gradient(180deg, rgba(255, 255, 255, 0.2), rgba(240, 248, 255, 0.44));
        pointer-events: none;
    }

    .services-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(110deg, rgba(255, 255, 255, 0.4) 0%, transparent 46%);
        pointer-events: none;
        animation: shimmerSweep 8s ease-in-out infinite alternate;
    }

    .services-hero .container::before,
    .services-hero .container::after {
        content: '';
        position: absolute;
        border-radius: 999px;
        pointer-events: none;
        z-index: 0;
        filter: blur(1px);
    }

    .services-hero .container::before {
        width: 170px;
        height: 170px;
        top: -20px;
        left: -36px;
        background: radial-gradient(circle, rgba(0, 180, 216, 0.22) 0%, rgba(0, 180, 216, 0) 72%);
        animation: floatOrbA 6.2s ease-in-out infinite;
    }

    .services-hero .container::after {
        width: 190px;
        height: 190px;
        bottom: 14px;
        right: -40px;
        background: radial-gradient(circle, rgba(0, 119, 182, 0.18) 0%, rgba(0, 119, 182, 0) 74%);
        animation: floatOrbB 7.5s ease-in-out infinite;
    }

    .services-hero .container {
        position: relative;
        z-index: 1;
        max-width: 1320px;
        width: 100%;
    }

    .booking-hero-panel {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 28px;
        align-items: center;
        margin-top: 12px;
        padding: 30px;
        border-radius: 30px;
        background: rgba(255, 255, 255, 0.72);
        border: 1px solid rgba(255, 255, 255, 0.86);
        box-shadow: 0 24px 64px rgba(0, 86, 137, 0.16);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
    }

    .booking-hero-panel:hover {
        transform: translateY(-6px);
        box-shadow: 0 30px 76px rgba(0, 86, 137, 0.2);
        border-color: rgba(255, 255, 255, 0.98);
    }

    .booking-hero-copy h3 {
        font-size: clamp(2rem, 3vw, 2.9rem);
        line-height: 1.12;
        font-weight: 900;
        color: var(--mc-slate-900);
        margin-bottom: 14px;
        letter-spacing: -0.03em;
        text-shadow: 0 10px 22px rgba(126, 181, 217, 0.22);
    }

    .booking-hero-copy p {
        color: var(--mc-slate-700);
        line-height: 1.8;
        margin-bottom: 22px;
        max-width: 620px;
    }

    .booking-hero-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 26px;
        border: none;
        border-radius: 999px;
        color: #fff;
        font-weight: 800;
        background: linear-gradient(135deg, var(--mc-cyan-500), var(--mc-blue-700));
        box-shadow: 0 14px 26px rgba(0, 119, 182, 0.26);
        transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
    }

    .booking-hero-button:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 20px 34px rgba(0, 119, 182, 0.34);
        filter: saturate(1.08);
    }

    .booking-hero-button:active {
        transform: translateY(-1px) scale(0.99);
    }

    .booking-hero-visual {
        border-radius: 26px;
        overflow: hidden;
        min-height: 380px;
        box-shadow: 0 24px 58px rgba(0, 64, 102, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.72);
        position: relative;
    }

    .booking-hero-visual::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(120deg, rgba(255, 255, 255, 0.36) 0%, transparent 38%);
        opacity: 0.45;
        pointer-events: none;
        transition: opacity 0.35s ease;
    }

    .booking-hero-visual img {
        width: 100%;
        height: 100%;
        min-height: 380px;
        object-fit: cover;
        object-position: center 20%;
        display: block;
        transition: transform 0.5s ease, filter 0.5s ease;
    }

    .booking-hero-visual:hover img {
        transform: scale(1.05);
        filter: saturate(1.07) contrast(1.03);
    }

    .booking-hero-visual:hover::after {
        opacity: 0.7;
    }

    .chooser-options {
        display: grid;
        gap: 12px;
        margin-top: 10px;
    }

    .chooser-option {
        display: flex;
        align-items: center;
        gap: 14px;
        width: 100%;
        text-align: left;
        padding: 16px 18px;
        border-radius: 18px;
        border: 1px solid rgba(0, 119, 182, 0.14);
        background: #f8fbff;
        color: var(--mc-slate-900);
        box-shadow: 0 8px 18px rgba(0, 86, 137, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .chooser-option:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 26px rgba(0, 86, 137, 0.14);
        border-color: rgba(0, 119, 182, 0.3);
    }

    .chooser-option i {
        width: 46px;
        height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: rgba(0, 180, 216, 0.12);
        color: var(--mc-blue-700);
        font-size: 1.2rem;
        flex: none;
    }

    .chooser-option strong {
        display: block;
        font-size: 1rem;
        margin-bottom: 2px;
    }

    .chooser-option span span {
        display: block;
        color: var(--mc-slate-700);
        font-size: 0.88rem;
        line-height: 1.4;
    }

    .booking-form-stage {
        margin-top: 18px;
        padding-top: 18px;
        border-top: 1px solid rgba(0, 119, 182, 0.12);
    }

    .booking-form-panel {
        display: none;
    }

    .booking-form-panel.active {
        display: block;
    }

    .booking-panel-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
    }

    .booking-back-btn {
        border: 1px solid rgba(0, 119, 182, 0.2);
        background: #f4fbff;
        color: var(--mc-blue-700);
        border-radius: 999px;
        padding: 8px 14px;
        font-weight: 700;
    }

    .booking-choice-hidden {
        display: block;
    }

    @media (max-width: 991px) {
        .booking-hero-panel {
            grid-template-columns: 1fr;
            padding: 22px;
        }

        .booking-hero-visual,
        .booking-hero-visual img {
            min-height: 280px;
        }
    }

    .crisis-form {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 6px;
        margin-top: 10px;
        text-align: left;
    }

    .crisis-form .form-group {
        display: flex;
        flex-direction: column;
        text-align: left;
        gap: 3px;
    }

    .crisis-form .form-group.full,
    .crisis-form .form-group.symptoms {
        grid-column: 1 / -1;
    }

    .crisis-form label {
        font-size: 0.74rem;
        color: var(--mc-slate-700);
        font-weight: 700;
    }

    .crisis-form input,
    .crisis-form select,
    .crisis-form textarea {
        width: 100%;
        padding: 8px 10px;
        border-radius: 12px;
        border: 1px solid rgba(0, 119, 182, 0.2);
        background: #ffffff;
        color: #16303f;
        font-size: 0.84rem;
    }

    .service-card.telemedicine-card {
        padding: 18px;
    }

    .service-card.telemedicine-card h3 {
        margin-bottom: 6px;
    }

    .service-card.telemedicine-card p {
        margin-bottom: 4px;
        line-height: 1.5;
    }

    .crisis-form input:focus,
    .crisis-form select:focus,
    .crisis-form textarea:focus {
        outline: none;
        border-color: rgba(0, 119, 182, 0.5);
        box-shadow: 0 0 0 3px rgba(0, 180, 216, 0.14);
    }

    .btn-whatsapp-hero {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        margin-top: 4px;
        border: none;
        border-radius: 999px;
        padding: 11px 16px;
        color: #ffffff;
        font-weight: 800;
        background: linear-gradient(135deg, var(--mc-cyan-500), var(--mc-blue-700));
        box-shadow: 0 10px 22px rgba(0, 119, 182, 0.3);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-whatsapp-hero:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(0, 119, 182, 0.38);
    }

    .telemedicine-notice {
        margin-top: 10px;
        padding: 10px 12px;
        border-radius: 12px;
        background: rgba(0, 119, 182, 0.08);
        border: 1px solid rgba(0, 119, 182, 0.2);
        color: #0b3f62;
        font-size: 0.85rem;
        line-height: 1.45;
    }

    .whish-payment-card {
        grid-column: 1 / -1;
        margin-top: 6px;
        padding: 14px;
        border-radius: 16px;
        background: linear-gradient(160deg, rgba(124, 58, 237, 0.08), rgba(0, 180, 216, 0.06));
        border: 1px solid rgba(124, 58, 237, 0.25);
    }

    .whish-payment-card .whish-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 800;
        color: #5b21b6;
        font-size: 0.92rem;
        margin-bottom: 6px;
    }

    .whish-payment-card .whish-steps {
        font-size: 0.78rem;
        color: #4c3d63;
        margin-bottom: 10px;
        line-height: 1.5;
    }

    .whish-transfer-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
        margin-bottom: 10px;
    }

    .whish-static-field {
        display: flex;
        flex-direction: column;
        gap: 3px;
        padding: 8px 10px;
        border-radius: 12px;
        background: #ffffff;
        border: 1px solid rgba(124, 58, 237, 0.2);
    }

    .whish-static-field span {
        font-size: 0.7rem;
        color: #6d5a8a;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }

    .whish-static-field strong {
        color: #3b0764;
        font-size: 0.95rem;
    }

    .services-hero .btn {
        border-radius: 999px;
        padding: 12px 26px;
        font-weight: 700;
    }

    .services-hero .btn-primary {
        background: linear-gradient(135deg, var(--mc-cyan-500), var(--mc-blue-700));
        border: none;
        box-shadow: 0 8px 24px rgba(0, 119, 182, 0.24);
    }

    .services-hero .btn-outline-primary {
        border-color: rgba(0, 119, 182, 0.35);
        color: var(--mc-blue-700);
        background: rgba(255, 255, 255, 0.72);
    }

    .services-grid {
        padding: 8px 0 36px;
        background: linear-gradient(180deg, rgba(244, 249, 254, 0.6), rgba(255, 255, 255, 0.92));
    }

    .services-section-head {
        text-align: center;
        max-width: 820px;
        margin: 0 auto 30px;
    }

    .services-section-head .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        margin-bottom: 16px;
        border-radius: 999px;
        background: rgba(0, 180, 216, 0.1);
        color: var(--mc-blue-700);
        font-size: 0.82rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.12em;
    }

    .services-section-head h2 {
        color: var(--mc-slate-900);
        font-size: clamp(2rem, 4vw, 2.8rem);
        font-weight: 900;
        letter-spacing: -0.03em;
        margin-bottom: 12px;
    }

    .services-section-head p {
        color: var(--mc-slate-700);
        line-height: 1.8;
        margin: 0 auto;
    }

    .services-hero .services-section-head {
        max-width: 900px;
        margin-bottom: 34px;
    }

    .services-hero .services-section-head .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        margin-bottom: 16px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.64);
        border: 1px solid rgba(255, 255, 255, 0.84);
        color: var(--mc-blue-700);
        font-size: 0.82rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.12em;
    }

    .services-hero .services-section-head h2 {
        color: var(--mc-slate-900);
        font-size: clamp(2rem, 4vw, 2.8rem);
        font-weight: 900;
        letter-spacing: -0.03em;
        margin-bottom: 12px;
        text-shadow: 0 12px 28px rgba(126, 181, 217, 0.2);
        animation: titleRise 0.8s ease 0.08s both;
    }

    .services-hero .services-section-head p {
        color: var(--mc-slate-700);
        line-height: 1.8;
        margin: 0 auto;
        animation: titleRise 0.8s ease 0.16s both;
    }

    .services-hero .services-section-head .eyebrow {
        animation: titleRise 0.8s ease both;
    }

    @keyframes heroFadeIn {
        from {
            opacity: 0;
            transform: translateY(14px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes titleRise {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shimmerSweep {
        0% {
            transform: translateX(-2%);
            opacity: 0.55;
        }
        100% {
            transform: translateX(2%);
            opacity: 0.85;
        }
    }

    @keyframes floatOrbA {
        0%,
        100% {
            transform: translate(0, 0);
        }
        50% {
            transform: translate(8px, 10px);
        }
    }

    @keyframes floatOrbB {
        0%,
        100% {
            transform: translate(0, 0);
        }
        50% {
            transform: translate(-10px, -8px);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .services-hero .container,
        .services-hero .container::before,
        .services-hero .container::after,
        .services-hero::after,
        .services-hero .services-section-head .eyebrow,
        .services-hero .services-section-head h2,
        .services-hero .services-section-head p {
            animation: none !important;
        }

        .booking-hero-panel,
        .booking-hero-button,
        .booking-hero-visual::after,
        .booking-hero-visual img {
            transition: none !important;
        }
    }

    .service-card {
        position: relative;
        background: var(--mc-surface);
        border-radius: 26px;
        border: 1px solid rgba(0, 119, 182, 0.11);
        box-shadow: 0 20px 48px rgba(0, 86, 137, 0.1);
        padding: 24px;
        min-height: 240px;
        height: 100%;
        transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
    }

    .service-card.appointment-card,
    .service-card.live-overview-card {
        min-height: 0;
        height: auto;
    }

    .service-card::after {
        content: '';
        position: absolute;
        inset: auto 20px 0;
        height: 3px;
        border-radius: 100px;
        background: linear-gradient(90deg, rgba(0, 180, 216, 0), rgba(0, 180, 216, 0.9), rgba(0, 119, 182, 0));
        transform: scaleX(0.35);
        transform-origin: center;
        opacity: 0;
        transition: transform 0.28s ease, opacity 0.28s ease;
    }

    .service-card:hover {
        transform: translateY(-9px);
        box-shadow: 0 30px 70px rgba(0, 95, 153, 0.16);
        border-color: rgba(0, 119, 182, 0.25);
    }

    .service-card:hover::after {
        transform: scaleX(1);
        opacity: 1;
    }

    .service-card i {
        color: var(--mc-blue-700);
        font-size: 2.3rem;
        margin-bottom: 14px;
    }

    .service-card .card-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(0, 180, 216, 0.12);
        color: var(--mc-blue-700);
        font-size: 0.82rem;
        font-weight: 800;
        letter-spacing: 0.02em;
    }

    .service-card h3 {
        color: var(--mc-slate-900);
        font-size: 1.32rem;
        margin-bottom: 10px;
        font-weight: 800;
    }

    .service-card p {
        color: var(--mc-slate-700);
        line-height: 1.68;
        margin-bottom: 0;
    }

    .service-card button {
        margin-top: 18px;
        background: linear-gradient(135deg, var(--mc-cyan-500), var(--mc-blue-700));
        border: none;
        border-radius: 999px;
        color: #fff;
        padding: 11px 22px;
        font-weight: 700;
        box-shadow: 0 8px 22px rgba(0, 119, 182, 0.24);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .service-card button:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 26px rgba(0, 119, 182, 0.34);
    }

    .service-card-action {
        display: inline-flex;
        margin-top: 18px;
        background: linear-gradient(135deg, var(--mc-cyan-500), var(--mc-blue-700));
        border-radius: 999px;
        color: #fff;
        padding: 11px 22px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 8px 22px rgba(0, 119, 182, 0.24);
    }

    .service-card-action:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 12px 26px rgba(0, 119, 182, 0.34);
    }

    .service-card .btn-whatsapp {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 18px;
        background: linear-gradient(135deg, #25d366, #128c7e);
        border: none;
        border-radius: 999px;
        color: #fff;
        padding: 11px 22px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 8px 22px rgba(18, 140, 126, 0.28);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .service-card .btn-whatsapp:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(18, 140, 126, 0.36);
        color: #fff;
    }

    .service-modal {
        position: fixed;
        inset: 0;
        background: rgba(6, 30, 48, 0.72);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 22px;
        z-index: 1200;
    }

    .service-modal.open {
        display: flex;
    }

    .service-modal .modal-panel {
        width: 100%;
        max-width: 700px;
        background: #ffffff;
        border-radius: 28px;
        padding: 34px;
        box-shadow: 0 30px 90px rgba(3, 26, 46, 0.3);
        border: 1px solid rgba(0, 119, 182, 0.14);
        position: relative;
    }

    .service-modal .modal-panel h2 {
        color: var(--mc-blue-800);
        margin-bottom: 16px;
        font-weight: 800;
    }

    .service-modal .modal-panel p {
        color: var(--mc-slate-700);
    }

    .service-modal .modal-panel .close-btn {
        position: absolute;
        top: 16px;
        right: 16px;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 1px solid rgba(0, 119, 182, 0.2);
        background: #f4fbff;
        font-size: 1.3rem;
        color: var(--mc-blue-700);
        cursor: pointer;
    }

    .service-modal .modal-panel label,
    .service-modal .modal-panel select,
    .service-modal .modal-panel input,
    .service-modal .modal-panel textarea {
        width: 100%;
        margin-bottom: 14px;
        font-size: 0.98rem;
    }

    .service-modal .modal-panel input,
    .service-modal .modal-panel select,
    .service-modal .modal-panel textarea {
        padding: 12px 14px;
        border-radius: 12px;
        border: 1px solid #cfe1ef;
        background: #f8fbff;
        color: #17334a;
    }

    .service-modal .modal-panel input:focus,
    .service-modal .modal-panel select:focus,
    .service-modal .modal-panel textarea:focus {
        outline: none;
        border-color: rgba(0, 119, 182, 0.5);
        box-shadow: 0 0 0 3px rgba(0, 180, 216, 0.15);
    }

    .service-modal .modal-panel button[type="submit"],
    .service-modal .modal-panel .modal-action {
        background: linear-gradient(135deg, var(--mc-cyan-500), var(--mc-blue-700));
        color: #ffffff;
        border: none;
        border-radius: 999px;
        padding: 11px 22px;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 8px 22px rgba(0, 119, 182, 0.24);
    }

    .service-modal .modal-panel .modal-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    #successMessage {
        color: var(--mc-blue-700) !important;
    }

    @media (max-width: 575px) {
        .service-modal .modal-panel {
            border-radius: 20px;
            padding: 24px;
        }

        .services-hero {
            padding: 56px 0 34px;
        }

        .services-hero .btn {
            width: 100%;
        }
    }
</style>

<section class="services-hero">
    <div class="container">
        <div class="services-section-head">
            <div class="eyebrow"><i class="fas fa-heartbeat"></i> Trusted care services</div>
            <h2>Exceptional medical services built for speed, clarity, and patient comfort</h2>
            <p>Explore HospiBridge's service experience with the same modern, blue-glass theme used across the site.</p>
        </div>
        <div class="booking-hero-panel">
            <div class="booking-hero-copy">
                <h3>One booking flow for every appointment type</h3>
                <p>Start with one button, then choose normal appointment, telemedicine, or vaccination. Each choice opens its own form without changing the database or admin dashboard flow.</p>
                <button type="button" class="booking-hero-button" onclick="openModal('bookingChooserModal')">Book Appointment</button>
            </div>
            <div class="booking-hero-visual">
                <img src="{{ asset('images/tele.jpeg') }}" alt="Telemedicine consultation" />
            </div>
        </div>
    </div>
</section>

<div class="service-modal" id="bookingChooserModal">
    <div class="modal-panel" style="max-width:540px;">
        <button class="close-btn" type="button" onclick="closeModal('bookingChooserModal')">&times;</button>
        <div id="bookingChoiceIntro" class="booking-choice-hidden">
            <h2>Choose appointment type</h2>
            <p>Select the form you want to complete.</p>
            <div class="chooser-options">
                <button type="button" class="chooser-option" onclick="showBookingForm('normal')">
                    <i class="fas fa-calendar-check"></i>
                    <span><strong>Normal Appointment</strong><span>Clinic visit with a doctor</span></span>
                </button>
                <button type="button" class="chooser-option" onclick="showBookingForm('telemedicine')">
                    <i class="fab fa-whatsapp"></i>
                    <span><strong>Telemedicine Appointment</strong><span>Remote consultation and follow-up</span></span>
                </button>
                <button type="button" class="chooser-option" onclick="showBookingForm('vaccination')">
                    <i class="fas fa-syringe"></i>
                    <span><strong>Vaccination Appointment</strong><span>Book a vaccine or booster</span></span>
                </button>
            </div>
        </div>

        <div id="bookingFormStage" class="booking-form-stage" style="display:none;">
            <div id="normalBookingPanel" class="booking-form-panel">
                <div class="booking-panel-topbar">
                    <h2 style="margin-bottom:0;">Normal Appointment</h2>
                    <button type="button" class="booking-back-btn" onclick="resetBookingChooser()">Back</button>
                </div>
                <form id="appointmentForm">
                    @csrf
                    <input type="hidden" name="appointment_type" value="normal">
                    <label>Full Name</label>
                    <input type="text" id="name" name="name" value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
                    <label>Email</label>
                    <input type="email" id="email" name="email" value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
                    <label>Phone</label>
                    <input type="tel" id="phone" name="phone" required placeholder="Enter phone for notifications">
                    <label>Choose Doctor</label>
                    <select id="doctor_id" name="doctor_id" required>
                        <option value="">-- Select Doctor --</option>
                        @foreach (($bookingDoctors ?? collect()) as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                    <label>Date</label>
                    <select id="schedule_date" name="schedule_date" required disabled>
                        <option value="">-- Select Date --</option>
                    </select>
                    <label>Time</label>
                    <select id="schedule_id" name="schedule_id" required disabled>
                        <option value="">-- Select Time --</option>
                    </select>
                    <label>Message</label>
                    <textarea id="message" name="message"></textarea>
                    <button type="submit">Book Now</button>
                    <p id="successMessage" style="display:none;color:#0577b8;font-weight:700;margin-top:16px;">Appointment booked successfully! You can track it under My Appointments.</p>
                </form>
            </div>

            <div id="telemedicineBookingPanel" class="booking-form-panel">
                <div class="booking-panel-topbar">
                    <h2 style="margin-bottom:0;">Telemedicine Appointment</h2>
                    <button type="button" class="booking-back-btn" onclick="resetBookingChooser()">Back</button>
                </div>
                <p>Fill this form and our team will continue the appointment on WhatsApp.</p>
                <form id="crisisTelemedicineForm" class="crisis-form">
                    <div class="form-group">
                        <label for="crisisName">Full Name</label>
                        <input type="text" id="crisisName" value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="crisisEmail">Email</label>
                        <input type="email" id="crisisEmail" value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="crisisPhone">WhatsApp Phone Number</label>
                        <input type="tel" id="crisisPhone" required>
                    </div>
                    <div class="form-group">
                        <label for="crisisLocation">Current Location</label>
                        <input type="text" id="crisisLocation" placeholder="City or area" required>
                    </div>
                    <div class="form-group">
                        <label for="crisisUrgency">Urgency Level</label>
                        <select id="crisisUrgency" required>
                            <option value="">Select urgency</option>
                            <option value="Critical">Critical</option>
                            <option value="Urgent">Urgent</option>
                            <option value="Moderate">Moderate</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="crisisDoctorId">Doctor</label>
                        <select id="crisisDoctorId" required>
                            <option value="">Select doctor</option>
                            @foreach (($bookingDoctors ?? collect()) as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="crisisDate">Available Date</label>
                        <select id="crisisDate" required disabled>
                            <option value="">Select date</option>
                        </select>
                    </div>
                    <div class="form-group full">
                        <label for="crisisTime">Available Time</label>
                        <select id="crisisTime" required disabled>
                            <option value="">Select time</option>
                        </select>
                    </div>
                    <div class="form-group full symptoms">
                        <label for="crisisSymptoms">Main Symptoms / Situation</label>
                        <textarea id="crisisSymptoms" rows="1" required></textarea>
                    </div>
                    <div class="whish-payment-card">
                        <div class="whish-title"><i class="fas fa-wallet"></i> Pay via Whish</div>
                        <p class="whish-steps">Open the Whish app &rarr; <strong>Whish to Whish</strong> &rarr; send the amount below to the number shown &rarr; paste your confirmation code below.</p>
                        <div class="whish-transfer-row">
                            <div class="whish-static-field">
                                <span>Send to</span>
                                <strong>81754630 (HospiBridge)</strong>
                            </div>
                            <div class="whish-static-field">
                                <span>Amount</span>
                                <strong>$20</strong>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="crisisWhishNumber">Your Whish Number</label>
                            <input type="tel" id="crisisWhishNumber" placeholder="Number you paid from" required>
                        </div>
                        <div class="form-group">
                            <label for="crisisWhishRef">Confirmation Code</label>
                            <input type="text" id="crisisWhishRef" placeholder="Whish transaction reference" required>
                        </div>
                    </div>
                    <div class="form-group full">
                        <button type="submit" class="btn-whatsapp-hero">
                            <i class="fab fa-whatsapp"></i>
                            Book Online via WhatsApp
                        </button>
                    </div>
                </form>
                <div id="telemedicineNotice" class="telemedicine-notice" style="display:none;"></div>
            </div>

            <div id="vaccinationBookingPanel" class="booking-form-panel">
                <div class="booking-panel-topbar">
                    <h2 style="margin-bottom:0;">Vaccination Appointment</h2>
                    <button type="button" class="booking-back-btn" onclick="resetBookingChooser()">Back</button>
                </div>
                <p>Choose from our full range of immunizations and keep your health on track.</p>
                <form id="vaccinationForm">
                    <label for="vaccinationName">Full Name</label>
                    <input type="text" id="vaccinationName" value="{{ auth()->check() ? auth()->user()->name : '' }}" required>
                    <label for="vaccinationEmail">Email</label>
                    <input type="email" id="vaccinationEmail" value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
                    <label for="vaccinationPhone">Phone</label>
                    <input type="tel" id="vaccinationPhone" required placeholder="Enter phone for notifications">
                    <label for="vaccine">Choose Vaccine</label>
                    <select id="vaccine" required>
                        <option>COVID-19</option>
                        <option>Flu</option>
                        <option>Hepatitis B</option>
                    </select>
                    <label for="doseNumber">Dose Number</label>
                    <select id="doseNumber" required>
                        <option value="First dose">First dose</option>
                        <option value="Second dose">Second dose</option>
                        <option value="Booster">Booster</option>
                    </select>
                    <label for="vaccineDate">Date</label>
                    <input type="date" id="vaccineDate" required>
                    <button type="submit">Book Vaccine</button>
                    <p id="vaccineSuccessMessage" style="display:none;color:#0577b8;font-weight:700;margin-top:16px;">Vaccination request booked! You can track it under My Appointments.</p>
                </form>
            </div>
        </div>
    </div>
</div>



<section class="services-grid">
    <div class="container">
        <div class="services-section-head">
            <div class="eyebrow"><i class="fas fa-layer-group"></i> Service catalogue</div>
            <h2>Everything you need in one polished healthcare experience</h2>
            <p>Designed to feel more like a premium healthcare platform than a standard services page, with stronger structure and cleaner visual rhythm.</p>
        </div>
        <div class="row g-4" id="serviceResults">
            <div class="col-md-4">
                <div class="service-card">
                    <span class="card-tag"><i class="fas fa-calendar-check"></i> Core service</span>
                    <i class="fas fa-calendar-check"></i>
                    <h3>Appointments</h3>
                    <p>Book doctors, lab visits, and follow-up care quickly with our secure scheduling process.</p>
                    <button type="button" onclick="requireLoginThen(() => openModal('appointmentsModal'))">Book Now</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card">
                    <span class="card-tag"><i class="fas fa-syringe"></i> Preventive care</span>
                    <i class="fas fa-syringe"></i>
                    <h3>Vaccinations</h3>
                    <p>Stay protected with flu shots, travel vaccines, and pediatric immunizations.</p>
                    <button type="button" onclick="requireLoginThen(() => openModal('vaccinationsModal'))">Learn More</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card">
                    <span class="card-tag"><i class="fas fa-prescription-bottle-medical"></i> Health tools</span>
                    <i class="fas fa-prescription-bottle-medical"></i>
                    <h3>Prescriptions</h3>
                    <p>Access your active prescriptions, refill requests, and medical guidance in one place.</p>
                    @auth
                        <button type="button" onclick="openModal('prescriptionsModal')">Request Prescription</button>
                    @else
                        <a href="{{ route('login') }}" class="service-card-action">Sign in to request</a>
                    @endauth
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card">
                    <span class="card-tag"><i class="fab fa-whatsapp"></i> Crisis telemedicine</span>
                    <i class="fab fa-whatsapp"></i>
                    <h3>Emergency Telemedicine</h3>
                    <p>During war zones or any emergency crisis, connect with our rapid-response medical team on WhatsApp for immediate triage, remote guidance, and urgent care coordination.</p>
                    <a class="btn-whatsapp" href="https://wa.me/96181754630?text=Hello%20HospiBridge%2C%20I%20need%20emergency%20telemedicine%20support." target="_blank" rel="noopener noreferrer">
                        <i class="fab fa-whatsapp"></i>
                        Start WhatsApp Support
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card">
                    <span class="card-tag"><i class="fas fa-notes-medical"></i> Scheduled telemedicine</span>
                    <i class="fas fa-notes-medical"></i>
                    <h3>Telemedicine Appointment</h3>
                    <p>Prefer a scheduled remote visit instead of an urgent one? Book a doctor and continue the consultation on WhatsApp.</p>
                    <button type="button" onclick="requireLoginThen(() => openModal('telemedicineModal'))">Book Now</button>
                </div>
            </div>
        </div>
        <p id="serviceSearchEmpty" class="text-center mt-4" hidden>No services match your search.</p>
    </div>
</section>

@auth
<div class="service-modal" id="prescriptionsModal">
    <div class="modal-panel" style="max-width:620px;">
        <button class="close-btn" type="button" onclick="closeModal('prescriptionsModal')">&times;</button>
        <h2>Request a prescription</h2>
        <p>Send the care team the details they need. Once reviewed, your prescription will appear in your patient dashboard as a downloadable PDF.</p>
        <form action="{{ route('prescription-requests.store') }}" method="POST">
            @csrf
            <label for="prescriptionName">Full name</label>
            <input id="prescriptionName" name="name" type="text" value="{{ auth()->user()->name }}" required>
            <label for="prescriptionPhone">Phone</label>
            <input id="prescriptionPhone" name="phone" type="tel" placeholder="Optional phone number">
            <label for="prescriptionDoctor">Doctor</label>
            <select id="prescriptionDoctor" name="doctor_id" required>
                <option value="">Select your doctor</option>
                @foreach (($bookingDoctors ?? collect()) as $doctor)
                    <option value="{{ $doctor->id }}">Dr. {{ $doctor->name }}</option>
                @endforeach
            </select>
            <label for="prescriptionMessage">What do you need?</label>
            <textarea id="prescriptionMessage" name="message" rows="5" placeholder="List the medication, refill request, symptoms, allergies, or other relevant details." required></textarea>
            <button type="submit">Submit prescription request</button>
        </form>
    </div>
</div>
@endauth

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const query = new URLSearchParams(window.location.search).get('q')?.trim().toLowerCase();
        const resultRows = document.querySelectorAll('#serviceResults > [class*="col-"]');
        const emptyState = document.getElementById('serviceSearchEmpty');

        if (!query || !resultRows.length) {
            return;
        }

        let visibleCount = 0;
        resultRows.forEach((resultRow) => {
            const serviceText = resultRow.textContent.toLowerCase();
            const isMatch = serviceText.includes(query);
            resultRow.hidden = !isMatch;
            if (isMatch) {
                visibleCount += 1;
            }
        });

        if (emptyState) {
            emptyState.hidden = visibleCount > 0;
        }
    });

    function openModal(id) {
        if (id === 'bookingChooserModal') {
            resetBookingChooser();
        }
        document.getElementById(id).classList.add('open');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('open');
        if (id === 'bookingChooserModal') {
            resetBookingChooser();
        }
    }

    function resetBookingChooser() {
        const intro = document.getElementById('bookingChoiceIntro');
        const stage = document.getElementById('bookingFormStage');
        const panels = ['normalBookingPanel', 'telemedicineBookingPanel', 'vaccinationBookingPanel'];

        if (intro) {
            intro.style.display = 'block';
        }

        if (stage) {
            stage.style.display = 'none';
        }

        panels.forEach((panelId) => {
            const panel = document.getElementById(panelId);
            if (panel) {
                panel.classList.remove('active');
            }
        });
    }

    function showBookingForm(type) {
        const intro = document.getElementById('bookingChoiceIntro');
        const stage = document.getElementById('bookingFormStage');
        const panelMap = {
            normal: 'normalBookingPanel',
            telemedicine: 'telemedicineBookingPanel',
            vaccination: 'vaccinationBookingPanel',
        };

        if (intro) {
            intro.style.display = 'none';
        }

        if (stage) {
            stage.style.display = 'block';
        }

        Object.values(panelMap).forEach((panelId) => {
            const panel = document.getElementById(panelId);
            if (panel) {
                panel.classList.remove('active');
            }
        });

        const activePanel = document.getElementById(panelMap[type]);
        if (activePanel) {
            activePanel.classList.add('active');
        }

        if (type === 'normal') {
            loadDoctors();
        }

        if (type === 'telemedicine') {
            loadTelemedicineDoctors();
        }
    }

    function loadDoctors() {
        fetch('/doctors')
            .then(res => res.json())
            .then(data => {
                const select = document.getElementById('doctor_id');
                select.innerHTML = '<option value="">-- Select Doctor --</option>';

                data.forEach(doc => {
                    const option = document.createElement('option');
                    option.value = doc.id;
                    option.textContent = doc.name;
                    select.appendChild(option);
                });
            })
            .catch(() => {
                console.error('Could not load doctors from API. Using server-rendered options.');
            });
    }

    document.getElementById('doctor_id').addEventListener('change', function () {
        const doctorId = this.value;
        const dateSelect = document.getElementById('schedule_date');
        const timeSelect = document.getElementById('schedule_id');

        dateSelect.innerHTML = '<option value="">-- Select Date --</option>';
        timeSelect.innerHTML = '<option value="">-- Select Time --</option>';
        dateSelect.disabled = true;
        timeSelect.disabled = true;

        if (!doctorId) {
            return;
        }

        fetch(`/doctor/${doctorId}/dates`)
            .then(res => res.json())
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    return;
                }

                dateSelect.disabled = false;
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item;
                    option.textContent = item;
                    dateSelect.appendChild(option);
                });
            })
            .catch(() => {
                console.error('Could not load schedule dates');
            });
    });

    document.getElementById('schedule_date').addEventListener('change', function () {
        const doctorId = document.getElementById('doctor_id').value;
        const selectedDate = this.value;
        const timeSelect = document.getElementById('schedule_id');

        timeSelect.innerHTML = '<option value="">-- Select Time --</option>';
        timeSelect.disabled = true;

        if (!doctorId || !selectedDate) {
            return;
        }

        fetch(`/doctor/${doctorId}/dates/${selectedDate}/times`)
            .then(res => res.json())
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    return;
                }

                timeSelect.disabled = false;
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = `${item.start_time} - ${item.end_time}`;
                    timeSelect.appendChild(option);
                });
            })
            .catch(() => {
                console.error('Could not load schedule times');
            });
    });

    document.getElementById('appointmentForm').addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('/appointments', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    const successMessage = document.getElementById('successMessage');
                    successMessage.style.display = 'block';

                    setTimeout(() => {
                        closeModal('appointmentsModal');
                        successMessage.style.display = 'none';
                        document.getElementById('appointmentForm').reset();
                        document.getElementById('schedule_date').disabled = true;
                        document.getElementById('schedule_id').disabled = true;
                    }, 1500);
                }
            })
            .catch(() => {
                console.error('Could not submit appointment');
            });
    });

    document.getElementById('crisisTelemedicineForm').addEventListener('submit', function (event) {
        event.preventDefault();
        event.stopImmediatePropagation();

        const doctorHotlineDisplay = '+961 81754630';
        const name = document.getElementById('crisisName').value.trim();
        const phone = document.getElementById('crisisPhone').value.trim();
        const location = document.getElementById('crisisLocation').value.trim();
        const urgency = document.getElementById('crisisUrgency').value;
        const selectedDoctorId = document.getElementById('crisisDoctorId').value;
        const crisisDoctorSelect = document.getElementById('crisisDoctorId');
        const selectedDoctorName = crisisDoctorSelect.options[crisisDoctorSelect.selectedIndex]?.text || '';
        const preferredDate = document.getElementById('crisisDate').value;
        const crisisTimeSelect = document.getElementById('crisisTime');
        const selectedScheduleId = crisisTimeSelect.value;
        const preferredTime = crisisTimeSelect.options[crisisTimeSelect.selectedIndex]?.text || crisisTimeSelect.value;
        const symptoms = document.getElementById('crisisSymptoms').value.trim();
        const whishNumber = document.getElementById('crisisWhishNumber').value.trim();
        const whishRef = document.getElementById('crisisWhishRef').value.trim();
        const notice = document.getElementById('telemedicineNotice');
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        if (!phone.replace(/\D/g, '')) {
            notice.textContent = 'Please enter a valid phone number so the admin can notify you on WhatsApp after acceptance.';
            notice.style.display = 'block';
            return;
        }

        if (!whishNumber || !whishRef) {
            notice.textContent = 'Please complete the Whish payment and enter your Whish number and confirmation code.';
            notice.style.display = 'block';
            return;
        }

        const formData = new FormData();
        formData.append('appointment_type', 'telemedicine');
        formData.append('name', name);
        formData.append('email', document.getElementById('crisisEmail').value.trim());
        formData.append('phone', phone);
        formData.append('doctor_id', selectedDoctorId);
        formData.append('schedule_id', selectedScheduleId);
        formData.append('location', location);
        formData.append('urgency', urgency);
        formData.append('symptoms', symptoms);
        formData.append('whish_number', whishNumber);
        formData.append('whish_reference', whishRef);
        formData.append('message', `Telemedicine booking | Location: ${location} | Urgency: ${urgency} | Symptoms: ${symptoms} | Whish ref: ${whishRef}`);

        fetch('/appointments', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf || ''
            },
            body: formData
        })
            .then(async (res) => {
                const contentType = res.headers.get('content-type') || '';
                const payload = contentType.includes('application/json') ? await res.json() : {};

                if (!res.ok || !payload.success) {
                    throw payload || { message: 'Could not save appointment. Please try again.' };
                }

                return payload;
            })
            .then(response => {
                notice.innerHTML = 'Appointment booked with <strong>' + selectedDoctorName + '</strong> on <strong>' + preferredDate + '</strong> at <strong>' + preferredTime + '</strong>. It is now pending admin confirmation. You will receive WhatsApp notification after admin accepts. Please be ready for the call. Hotline: <strong>' + doctorHotlineDisplay + '</strong>.';
                notice.style.display = 'block';
                event.target.reset();

                document.getElementById('crisisDate').innerHTML = '<option value="">Select date</option>';
                document.getElementById('crisisTime').innerHTML = '<option value="">Select time</option>';
                document.getElementById('crisisDate').disabled = true;
                document.getElementById('crisisTime').disabled = true;
            })
            .catch((error) => {
                notice.textContent = error?.message || 'Could not save appointment. Please try again.';
                notice.style.display = 'block';
            });
    }, true);

    function loadTelemedicineDoctors() {
        fetch('/doctors')
            .then(res => res.json())
            .then(data => {
                const select = document.getElementById('crisisDoctorId');
                select.innerHTML = '<option value="">Select doctor</option>';

                data.forEach(doc => {
                    const option = document.createElement('option');
                    option.value = doc.id;
                    option.textContent = doc.name;
                    select.appendChild(option);
                });
            })
            .catch(() => {
                console.error('Could not load telemedicine doctors from API. Using server-rendered options.');
            });
    }

    document.getElementById('crisisDoctorId').addEventListener('change', function () {
        const doctorId = this.value;
        const dateSelect = document.getElementById('crisisDate');
        const timeSelect = document.getElementById('crisisTime');

        dateSelect.innerHTML = '<option value="">Select date</option>';
        timeSelect.innerHTML = '<option value="">Select time</option>';
        dateSelect.disabled = true;
        timeSelect.disabled = true;

        if (!doctorId) {
            return;
        }

        fetch(`/doctor/${doctorId}/dates`)
            .then(res => res.json())
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    return;
                }

                dateSelect.disabled = false;
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item;
                    option.textContent = item;
                    dateSelect.appendChild(option);
                });
            })
            .catch(() => {
                console.error('Could not load telemedicine dates');
            });
    });

    document.getElementById('crisisDate').addEventListener('change', function () {
        const doctorId = document.getElementById('crisisDoctorId').value;
        const selectedDate = this.value;
        const timeSelect = document.getElementById('crisisTime');

        timeSelect.innerHTML = '<option value="">Select time</option>';
        timeSelect.disabled = true;

        if (!doctorId || !selectedDate) {
            return;
        }

        fetch(`/doctor/${doctorId}/dates/${selectedDate}/times`)
            .then(res => res.json())
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    return;
                }

                timeSelect.disabled = false;
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = `${item.start_time} - ${item.end_time}`;
                    timeSelect.appendChild(option);
                });
            })
            .catch(() => {
                console.error('Could not load telemedicine times');
            });
    });

    loadTelemedicineDoctors();
</script>
@endsection