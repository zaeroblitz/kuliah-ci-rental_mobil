<?php

class Autentifikasi extends CI_Controller
{
    public function index()
    {
        //jika statusnya sudah login, maka tidak bisa mengakses halaman login alias dikembalikan ke tampilan user
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        // Email Validation
        $this->form_validation->set_rules('email', 'Alamat Email', 'required|trim|valid_email', [
            'required' => 'Email Harus Diisi',
            'valid_email' => 'Email Tidak Benar',
        ]);

        // Password Validation
        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => 'Password Harus Diisi'
        ]);


        if ($this->form_validation->run() == false) {
            //kata 'login' merupakan nilai dari variabel judul dalam array $data dikirimkan ke view aute_header
            $data['judul'] = 'Login';
            $data['user'] = '';

            $this->load->view('templates/aute_header.php', $data);
            $this->load->view('autentifikasi/login');
            $this->load->view('templates/aute_footer.php');
        } else {
            $this->_login();
        }
    }

    public function _login()
    {
        $email = htmlspecialchars($this->input->post('email', true));
        $password = $this->input->post('password', true);
        $user = $this->ModelUser->cekData(['email' => $email])->row_array();

        // Jika usernya ada
        if ($user) {

            // Jika user sudah aktif
            if ($user['is_active'] == 1) {

                // Cek Password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id'],
                    ];

                    $this->session->set_userdata($data);

                    // Cek User Role (Admin/Member)
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        if ($user['image'] == 'default.jpg') {
                            $this->session->set_flashdata('pesan', '<div class="alert alert-info alert-message" role="alert">Silahkan
                            Ubah Profile Anda untuk Ubah Photo Profil</div>');
                        }
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('pesan', '<div
                    class="alert alert-danger alert-message" role="alert">Password
                    salah!! <?php echo $password; ?></div>');
                    redirect('autentifikasi');
                }
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">User belum diaktifasi!!</div>');
                redirect('autentifikasi');
            }
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">Email tidak terdaftar!!</div>');
            redirect('autentifikasi');
        }
    }

    public function blok()
    {
        $this->load->view('autentifikasi/blok');
    }

    public function gagal()
    {
        $this->load->view('autentifikasi/gagal.php');
    }

    public function registrasi()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        // Membuat rule untuk inputan nama agar tidak boleh kosong dengan membuat pesan error dengan bahasa sendiri yaitu 'Nama Belum Diisi'
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required', [
            'required' => 'Nama belum diisi!!!'
        ]);

        // Membuat rule untuk inputan email agar tidak boleh kosong, tidak ada spasi, format email harus valid dan email belum pernah dipakai sama user lain dengan membuat pesan error dengan bahasa sendiri
        // Yaitu jika format email tidak benar maka pesannya 'Email Tidak Benar!!'
        // Jika email belum diisi, maka pesannya adalah 'Email Belum Diisi!!'
        // Jika email yang diinput sudah dipakai user lain, maka pesannya adalah 'Email Sudah Terdaftar'
        $this->form_validation->set_rules('email', 'Alamat Email', 'required|trim|valid_email|is_unique[user.email]', [
            'valid_email' => 'Email Tidak Benar!!!',
            'required' => 'Email Belum Diisi!!!',
            'is_unique' => 'Email Sudah Terdaftar!!!'
        ]);

        // Membuat rule untuk inputan password agat tidak boleh kosong, tidak ada spasi tidak boleh kurang dari 3 digit, dan password harus sama dengan repeat password dengan membuat pesan error dengan bahasa sendiri yaitu:
        // Jika Password dan Repeat Password tidak diinput sama, maka pesannya adalah 'Password Tidak Sama'
        // Jika Password diisi kurang dari 3 digit, maka pesannya adalah 'Password Terlalu Pendek'
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password Tidak Sama!!!',
            'min_length' => 'Password Terlalu Pendek',
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[3]|matches[password1]');

        // Jika disubmit kemudian validasi form diatas tidak berjalan, maka akan tetap berada di tampilan registrasi, 
        // Tapi jika disubmit kemudian validasi form diatas berjalan, maka data yang diinput akan disimpan ke dalam tabel user 
        if ($this->form_validation->run() == false) {
            $data['judul'] = 'Registrasi Member';
            $this->load->view('templates/aute_header', $data);
            $this->load->view('autentifikasi/registrasi');
            $this->load->view('templates/aute_footer');
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'tanggal_input' => time(),
            ];

            $this->ModelUser->simpanData($data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert">Selamat!! Akun Member Anda Sudah Dibuat. Silahkan Aktivasi Akun Anda </div>');
            redirect('autentifikasi');
        }
    }

    public function logout()
    {        
        $this->session->sess_destroy();
        redirect('autentifikasi');
    }
}
