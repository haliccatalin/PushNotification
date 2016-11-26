package ro.halic.catalin.pushnotification;

import android.util.Log;

import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.iid.FirebaseInstanceIdService;

import java.io.IOException;

import okhttp3.FormBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;
import okhttp3.ResponseBody;

/**
 * Created by Catalin on 25.11.2016.
 */

public class FirebaseInstanceIDService extends FirebaseInstanceIdService {

    @Override
    public void onTokenRefresh() {
        String token  = FirebaseInstanceId.getInstance().getToken();

        registerToken(token);
    }

    private void registerToken(String token) {
        OkHttpClient client = new OkHttpClient();

        RequestBody body = new FormBody.Builder()
                .add("Tokens", token)
                .build();

        Request request = new Request.Builder()
                .url("http://catalinhalic.ddns.net:8080/register.php")
                .post(body)
                .build();

        try {
            Log.e("REQUEST", request.toString());
            Response res =  client.newCall(request).execute();

            ResponseBody bodyres = res.body();
            String b = bodyres.string();
            Log.i("response", b);
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}
