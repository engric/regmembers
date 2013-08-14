package com.example.regdemo;

import java.io.File;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

public class NextPage extends Activity {
	private static final int CAPTURE_IMAGE_ACTIVITY_REQUEST_CODE = 100;
	private Uri fileUri;
	public static final int MEDIA_TYPE_IMAGE = 1;
	public static final int MEDIA_TYPE_VIDEO = 2;
	private String[] frompageone;
	private Bitmap bitmap;
	private  Button pigaPicha;
	private ImageView image;
	String url="";
	private static final int CAPTURE_VIDEO_ACTIVITY_REQUEST_CODE = 200;
	 @Override
	    protected void onCreate(Bundle savedInstanceState) {
	        super.onCreate(savedInstanceState);
	        setContentView(R.layout.nextpage);
	        Intent pageone=getIntent();
	    frompageone= pageone.getStringArrayExtra("pageone");
	        pigaPicha=(Button)findViewById(R.id.pigapicha);
	        image=(ImageView)findViewById(R.id.image);
	        Button tumaData=(Button)findViewById(R.id.tumadata);
	         url=this.getResources().getString(R.string.apiURL);
	        //capture image action
	        pigaPicha.setOnClickListener(new OnClickListener(){
				@Override
				public void onClick(View v) {
					// create Intent to take a picture and return control to the calling application
				    Intent intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
				    fileUri = CameraProcess.getOutputMediaFileUri(MEDIA_TYPE_IMAGE);
				    intent.putExtra(MediaStore.EXTRA_OUTPUT, fileUri); // set the image file name

				    // start the image capture Intent
				    startActivityForResult(intent, CAPTURE_IMAGE_ACTIVITY_REQUEST_CODE);
				}
	        	
	        });
	        
	        //send data action
	        tumaData.setOnClickListener(new OnClickListener(){
				@Override
				public void onClick(View v) {
					
					EditText kiasiMkopo=(EditText)findViewById(R.id.mkopokiasi);
					DatePicker tareheMkopo=(DatePicker)findViewById(R.id.tarehemkopo);
					EditText nenosiri=(EditText)findViewById(R.id.nenosiri);
					int month=tareheMkopo.getMonth()+1;
					int year=tareheMkopo.getYear();
					int day=tareheMkopo.getDayOfMonth();
					String tarehe=""+year+"-"+month+"-"+day;
					MyClient clients=new MyClient(url,fileUri.getEncodedPath());
					clients.addParam("jina", frompageone[0]);
					clients.addParam("mkoa", frompageone[1]);
					clients.addParam("wilaya", frompageone[2]);
					clients.addParam("kata", frompageone[3]);
					clients.addParam("simu", frompageone[4]);
					clients.addParam("kikundi", frompageone[5]);
					clients.addParam("biashara",frompageone[6]);
					clients.addParam("mkopo", kiasiMkopo.getText().toString());
					clients.addParam("tarehemkopo",tarehe);
					clients.addParam("nenosiri", nenosiri.getText().toString());
					String result=clients.sendMultiformData();
					Toast.makeText(NextPage.this, result, Toast.LENGTH_LONG).show();
					// create Intent to take a picture and return control to the calling application
	           }        
	        	
	        });
	    }


	    @Override
	    public boolean onCreateOptionsMenu(Menu menu) {
	        // Inflate the menu; this adds items to the action bar if it is present.
	        getMenuInflater().inflate(R.menu.main, menu);
	        return true;
	    }

	    @Override
	    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
	        if (requestCode == CAPTURE_IMAGE_ACTIVITY_REQUEST_CODE) {
	            if (resultCode == RESULT_OK) {
	                // Image captured and saved to fileUri specified in the Intent
	            //	 Toast.makeText(NextPage.this,"myfile"+fileUri, Toast.LENGTH_LONG).show();
	            	 
	            	 bitmap=BitmapFactory.decodeFile(fileUri.getEncodedPath());
	            	image.setImageBitmap(bitmap);
	               // Toast.makeText(NextPage.this, "Image saved to:\n"+data.getData(), Toast.LENGTH_LONG).show();
	            } else if (resultCode == RESULT_CANCELED) {
	            Toast.makeText(NextPage.this, "Camera Cancelled:", Toast.LENGTH_LONG).show();
	                // User cancelled the image capture
	            } else {
	                // Image capture failed, advise user
	            }
	        }

	        if (requestCode == CAPTURE_VIDEO_ACTIVITY_REQUEST_CODE) {
	            if (resultCode == RESULT_OK) {
	                // Video captured and saved to fileUri specified in the Intent
	                //Toast.makeText(NextPage.this, "Video saved to:\n"+data.getData(), Toast.LENGTH_LONG).show();
	            } else if (resultCode == RESULT_CANCELED) {
	                // User cancelled the video capture
	            } else {
	                // Video capture failed, advise user
	            }
	        }
	    }
}
