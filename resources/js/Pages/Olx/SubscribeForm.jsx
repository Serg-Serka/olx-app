import Guest from "@/Layouts/GuestLayout.jsx";
import {Head} from "@inertiajs/react";
import { useForm } from '@inertiajs/react';
import TextInput from '@/Components/TextInput';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import axios from "axios";
import {useState} from "react";
import Modal from "@/Components/Modal.jsx";

export default function SubscribeForm() {

    const { data, setData, post, errors, processing, recentlySuccessful } = useForm({
        url: '',
        email: '',
    });

    const [showModal, setShowModal] = useState(false);
    const [modalMessage, setModalMessage] = useState('');

    const submit = (e) => {
        e.preventDefault();

        axios.post(route('olx.subscribe'), data).then(response => {
            setShowModal(true);
            setModalMessage(response.data.message);
            // console.log(response.data);
        });
    };

    return (
        <Guest>
            <Head title="OLX subscriber" />
            <form onSubmit={submit} >
                <div>
                    <InputLabel htmlFor="url" value="URL"/>

                    <TextInput
                        id="url"
                        className="mt-1 block w-full"
                        value={data.url}
                        onChange={(e) => setData('url', e.target.value)}
                        required
                    />
                </div>
                <div className="mt-2">
                    <InputLabel htmlFor="email" value="Email"/>

                    <TextInput
                        id="email"
                        className="mt-1 block w-full"
                        value={data.email}
                        onChange={(e) => setData('email', e.target.value)}
                        required
                    />
                </div>

                <div className="flex items-center gap-4 mt-2">
                    <PrimaryButton disabled={processing}>Save</PrimaryButton>
                </div>
            </form>

            <Modal show={showModal} onClose={() => setShowModal(false)}>
                <div className="p-5">
                    {modalMessage}
                </div>
            </Modal>
        </Guest>
    );
}
