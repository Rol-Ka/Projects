@extends('layouts.app')

@section('content')

<div class="grid grid-2">

    <!-- <div class="card">
        <p class="muted">Sąskaitų skaičius</p>
        <h1>{{ count($accounts) }}</h1>
    </div>

    <div class="card">
        <p class="muted">Bendras banko balansas</p>
        <h1>{{ number_format($totalBalance, 2) }} €</h1>
    </div> -->



    <table class="table">

        <thead>
            <tr>
                <th>#</th>
                <th>Vardas</th>
                <th>Pavardė</th>
                <th>IBAN</th>
                <th>Balansas</th>
                <th>Veiksmai</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($accounts as $acc)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $acc['name'] }}</td>
                <td>{{ $acc['surname'] }}</td>
                <td>{{ $acc['iban'] }}</td>
                <td class="balance {{ $acc['balance'] > 0 ? 'balance-positive' : 'balance-zero' }}">
                    {{ number_format($acc['balance'], 2) }} €
                </td>

                <td class="actions">
                    <a href="{{ route('accounts.add.form', $acc['id']) }}" class="btn btn-primary">
                        Pridėti lėšų
                    </a>

                    <a href="{{ route('accounts.withdraw.form', $acc['id']) }}" class="btn btn-primary">
                        Atimti lėšų
                    </a>

                    <form method="POST" action="{{ route('accounts.destroy', $acc['id']) }}" class="delete-form">
                        @csrf
                        @method('DELETE')

                        <button type="button"
                            class="btn btn-danger open-delete-modal"
                            data-id="{{ $acc['id'] }}"
                            data-balance="{{ $acc['balance'] }}">
                            Ištrinti sąskaitą
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
    <div id="modal" class="modal hidden">
        <div class="modal-box">

            <p id="modal-text">Ar tikrai norite ištrinti šią sąskaitą?</p>

            <div class="modal-actions">
                <button id="cancel" class="btn">Atšaukti</button>
                <button id="confirm" class="btn btn-danger">Taip, trinti</button>
            </div>

        </div>
    </div>
</div>


<br>
<script>
    let formToSubmit = null;

    document.querySelectorAll('.open-delete-modal').forEach(btn => {
        btn.addEventListener('click', () => {

            const balance = parseFloat(btn.dataset.balance);

            if (balance > 0) {
                showToast("Negalima ištrinti — sąskaitoje yra lėšų", "error");
                return;
            }

            formToSubmit = btn.closest('form');
            document.getElementById('modal').classList.remove('hidden');
        });
    });

    document.getElementById('cancel').onclick = () => {
        document.getElementById('modal').classList.add('hidden');
    };

    document.getElementById('confirm').onclick = () => {
        formToSubmit.submit();
    };
</script>

@endsection