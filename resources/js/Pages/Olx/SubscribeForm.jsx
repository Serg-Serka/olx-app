import Guest from "@/Layouts/GuestLayout.jsx";
import {Head} from "@inertiajs/react";
import { useForm } from '@inertiajs/react';
import TextInput from '@/Components/TextInput';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import {Transition} from "@headlessui/react";
import axios from "axios";

export default function SubscribeForm() {

    const { data, setData, post, errors, processing, recentlySuccessful } = useForm({
        url: '',
        email: '',
    });

    const submit = (e) => {
        e.preventDefault();

        axios.post(route('olx.subscribe'), data).then(response => {
            console.log(response.data);
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

                    {/*<Transition*/}
                    {/*    show={recentlySuccessful}*/}
                    {/*    enter="transition ease-in-out"*/}
                    {/*    enterFrom="opacity-0"*/}
                    {/*    leave="transition ease-in-out"*/}
                    {/*    leaveTo="opacity-0"*/}
                    {/*>*/}
                    {/*    <p className="text-sm text-gray-600">Saved.</p>*/}
                    {/*</Transition>*/}
                </div>
            </form>
        </Guest>
    );
}
