<style>
    .promotion-label {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #48aa71;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: bold;
        z-index: 1;
        animation: shimmer 1.5s infinite;
    }

    @keyframes shimmer {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
        }

    }
</style>
<div class="promotion-label">Promoção</div>

